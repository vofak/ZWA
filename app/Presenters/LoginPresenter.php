<?php


namespace App\Presenters;


use App\model\dal\dao\MemberDAO;
use App\model\dal\metadata\MemberMetadata;
use App\model\dal\metadata\RankMetadata;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use Nette\Application\UI\Presenter;
use Nette\Security\Identity;
use Throwable;

/**
 * Class LoginPresenter
 * @package App\Presenters
 */
class LoginPresenter extends Presenter
{
    /**
     * @inject
     * @var Google
     */
    public Google $google;

    /**
     * @inject
     * @var MemberDAO
     */
    public MemberDAO $memberDAO;

    protected function beforeRender()
    {
        parent::beforeRender();
        $this->setLayout("layoutLoggedOut");
    }

    # IN

    public function handleGoogleLogin(): void
    {
        $authorizationUrl = $this->google->getAuthorizationUrl([
            'redirect_uri' => $this->link('//in'),
        ]);

        $this->getSession(Google::class)->state = $this->google->getState();
        $this->redirectUrl($authorizationUrl);
    }

// todo move from presenter
    public function actionIn(): void
    {
        $error = $this->getParameter('error');
        if ($error !== null) {
            $this->flashMessage('... google login error ...', 'error');
            $this->redirect('Homepage:default');
        }

        $state = $this->getParameter('state');
        $stateInSession = $this->getSession(Google::class)->state;
        if ($state === null || $stateInSession === null || !\hash_equals($stateInSession, $state)) {
            $this->flashMessage('... invalid CSRF token ...', 'error');
            $this->redirect('Homepage:default');
        }

        // reset CSRF protection, it has done its job
        unset($this->getSession(Google::class)->state);

        $accessToken = $this->google->getAccessToken('authorization_code', [
            'code' => $this->getParameter('code'),
            'redirect_uri' => $this->link('//in'),
        ]);

        try {
            /** @var GoogleUser $googleUser */
            $googleUser = $this->google->getResourceOwner($accessToken);
        } catch (Throwable $e) {
            $this->flashMessage('... cannot retrieve user profile ...', 'error');
            $this->redirect('default');
        }

        // Try to log in with google id
        $googleId = $googleUser->getId();
        $member = $this->memberDAO->findMemberByGoogleId($googleId);
        // If the member has never logged in and does not have google id in the database, try it with email
        if (!$member) {
            $googleEmail = $googleUser->getEmail();
            $member = $this->memberDAO->findMemberByEmail($googleEmail);
            // no google id + no email --> no user
            if (!$member) {
                $this->flashMessage("Your account is not in the database. If you feel like it's an error in the matrix, contact it@bestprague.cz with the subject 'HEEEEEEELP! Members won't let me in :('");
                $this->redirect("default");
            }
            $member->update(array(MemberMetadata::$googleId => $googleId));
        }
        $member->update(array(MemberMetadata::$googleImage => $googleUser->getAvatar()));
        // Members with improper ranks are not allowed
        $memberRank = $member->ref(RankMetadata::$tableName, MemberMetadata::$rankId);
        if (!$memberRank[RankMetadata::$hasAccessRight]) {
            $this->flashMessage("Your rank does not have access to this application. If you feel like it's an error in the matrix, contact it@bestprague.cz with the subject 'HEEEEEEELP! Members won't let me in :('");
            $this->redirect("default");
        }

        // They passed all the tests, now they shall enter
        $this->getUser()->login(new Identity($member[MemberMetadata::$memberId], $member[MemberMetadata::$role], array("firstName" => $member[MemberMetadata::$firstName], "lastName" => $member[MemberMetadata::$lastName])));
        $this->redirect('Homepage:');
    }

    # OUT

    public function actionOut()
    {
        $this->getUser()->logout(true);
        $this->redirect("Login:");
    }
}