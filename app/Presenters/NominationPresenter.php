<?php


namespace App\Presenters;


use App\model\dal\metadata\NominationMetadata;
use App\model\facade\election\ElectionFacade;
use App\model\templating\BootstrapForm;
use Nette\Application\UI\Presenter;

/**
 * Class NominationPresenter
 * @package App\Presenters
 */
class NominationPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var ElectionFacade
     */
    public ElectionFacade $electionFacade;

    // CREATE

    public function actionCreate(int $electionId)
    {
        $this['nominationForm']->setDefaults(array(NominationMetadata::$electionId => $electionId));
        $this['nominationForm']->onSuccess[] = array($this, 'handleCreateNominationFormSubmit');
    }

    public function renderCreate(int $electionId) {
        $this->template->electionId = $electionId;
    }

    public function createComponentNominationForm()
    {
        $electionId = $this->getParameter("electionId");
        $nominationEditFormOTO = $this->electionFacade->getNominationEditForm($electionId);

        $form = new BootstrapForm();
        $form->setTranslator($this->translator);

        $form->addHidden(NominationMetadata::$electionId);

        $form->addSelect(NominationMetadata::$boardPositionId, 'messages.nomination.position', $nominationEditFormOTO->getBoardPositionOptions());
        $form->addSelect(NominationMetadata::$nomineeId, 'messages.nomination.nominee', $nominationEditFormOTO->getNomineeOptions());
        $form->addTextArea(NominationMetadata::$note, 'messages.nomination.description')
            ->setNullable()
            ->setOption('description', 'messages.nomination.descriptionDescription');

        $form->addSubmit('submit', 'messages.nomination.nominate');

        return $form;
    }

    public function handleCreateNominationFormSubmit($form, array $values)
    {
        $nominationId = $this->electionFacade->addNomination($values);

        $this->flashMessage($this->translator->translate("messages.common.createSuccess"), 'success');
        $this->redirect('Election:list');
    }

}