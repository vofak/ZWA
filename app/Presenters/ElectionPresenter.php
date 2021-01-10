<?php

declare(strict_types=1);


namespace App\Presenters;


use App\model\dal\metadata\ElectionMetadata;
use App\model\facade\election\ElectionFacade;
use App\model\templating\BootstrapForm;

/**
 * Class ElectionPresenter
 * @package App\Presenters
 */
class ElectionPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var ElectionFacade
     */
    public ElectionFacade $electionFacade;

    public function renderList()
    {
        $this->template->electionBrowseViewOTO = $this->electionFacade->getElectionBrowseView();
    }

    public function renderDetail(int $electionId)
    {
        $this->template->electionDetailOTO = $this->electionFacade->getElectionDetail($electionId);
    }

    public function renderAdminDetail(int $electionId)
    {
        $this->template->electionAdminDetailOTO = $this->electionFacade->getElectionAdminDetail($electionId);
    }

    protected function createComponentElectionForm()
    {
        $electionEditFormOTO = $this->electionFacade->getElectionEditForm();

        $form = new BootstrapForm();
        $form->setTranslator($this->translator);

        $form->addHidden(ElectionMetadata::$electionId)
            ->setNullable();
        $form->addText(ElectionMetadata::$name, 'messages.election.name')
            ->setRequired('messages.election.nameRequired');

        $form->addDate(ElectionMetadata::$startDate, "messages.election.startDate")
            ->setRequired("messages.election.startDateRequired");

        $form->addDate(ElectionMetadata::$endDate, "messages.election.endDate")
            ->setRequired("messages.election.endDateRequired");

        $form->addCheckbox(ElectionMetadata::$isPublished, "messages.election.publishedDescription");
        $form->addCheckboxList('positions', 'messages.election.positions', $electionEditFormOTO->getBoardPositionOptions());
        $form->addSubmit('submit', 'messages.common.submit');

        return $form;
    }

    public function handleEditElectionFormSubmit($form, array $values)
    {
        //$replacedValues = $this->replaceEmptyWithNull($values);
        $values[ElectionMetadata::$electionId] = intval($values[ElectionMetadata::$electionId]);
        $electionId = $this->electionFacade->updateElection($values);

        $this->flashMessage($this->translator->translate("messages.common.editSuccess"), 'success');
        $this->redirect('Election:list');
    }

    public function handleCreateElectionFormSubmit($form, array $values)
    {
        //$replacedValues = $this->replaceEmptyWithNull($values);
        $electionId = $this->electionFacade->addElection($values);

        $this->flashMessage($this->translator->translate("messages.common.createSuccess"), 'success');
        $this->redirect('Election:list');
    }

    public function actionEdit(int $electionId)
    {
        $electionArray = $this->electionFacade->getElectionForForm($electionId);
        $this['electionForm']->setDefaults($electionArray);
        $this['electionForm'][ElectionMetadata::$startDate]->setDefaultValue($electionArray[ElectionMetadata::$startDate]->format("Y-m-d"));
        $this['electionForm'][ElectionMetadata::$endDate]->setDefaultValue($electionArray[ElectionMetadata::$endDate]->format("Y-m-d"));
        $this['electionForm']->onSuccess[] = array($this, 'handleEditElectionFormSubmit');
    }

    public function actionCreate()
    {
        $this['electionForm']->onSuccess[] = array($this, 'handleCreateElectionFormSubmit');
    }

    public function handleDeleteElection(int $electionId)
    {
        $this->electionFacade->deleteElection($electionId);
        $this->flashMessage($this->translator->translate('messages.common.deleteSuccess'), 'success');
        $this->redirect('this');
    }

}