<?php


namespace App\model\core\localization;



use App\model\dal\dao\MemberDAO;
use App\model\dal\metadata\LanguageMetadata;
use App\model\dal\metadata\MemberMetadata;
use Contributte;
use Contributte\Translation\LocalesResolvers\ResolverInterface;
use Contributte\Translation\Translator;
use Nette\Security\User;

/**
 * Class LocaleResolver
 *
 * Component implementing ResolverInterface. Resolves locale from the user's member entity in database
 *
 * @package App\model\core\localization
 */
class LocaleResolver implements ResolverInterface
{
    private User $user;
    private MemberDAO $memberDAO;

    /**
     * LocaleResolver constructor.
     *
     * @param User $user
     * @param MemberDAO $memberDAO
     */
    public function __construct(User $user, MemberDAO $memberDAO)
    {
        $this->user = $user;
        $this->memberDAO = $memberDAO;
    }

    /**
     * Resolves current user's locale
     *
     * @param Translator $translator
     * @return string|null the locale in current user's member entity in database or null
     */
    public function resolve(Translator $translator): ?string
    {
        if (!$this->user->isLoggedIn()) {
            return null;
        }
        $userId = $this->user->getId();
        $memberEO = $this->memberDAO->getMember($userId);

        $languageEO = $memberEO->ref(LanguageMetadata::$tableName, MemberMetadata::$languageId);
        if (!$languageEO) {
            return null;
        }

        return $languageEO[LanguageMetadata::$iso2];
    }
}