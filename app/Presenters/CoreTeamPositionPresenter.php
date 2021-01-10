<?php


namespace App\Presenters;


use App\model\dal\metadata\CoreTeamPositionMetadata;
use App\model\facade\event\EventFacade;
use App\model\templating\BootstrapForm;

/**
 * Class CoreTeamPositionPresenter
 * @package App\Presenters
 */
class CoreTeamPositionPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var EventFacade
     */
    public EventFacade $eventFacade;

    protected function createComponentCoreTeamPositionForm()
    {
        $coreTeamPositionEditFormOTO = $this->eventFacade->getCoreTeamPositionEditForm();

        $form = new BootstrapForm();

        $form->addHidden(CoreTeamPositionMetadata::$eventId);
        $form->addHidden(CoreTeamPositionMetadata::$coreTeamPositionId);
        $form->addText(CoreTeamPositionMetadata::$name, 'messages.ctpos.name')
            ->setRequired('messages.ctpos.nameRequired');

        $form->addSelect(CoreTeamPositionMetadata::$memberId, 'messages.ctpos.member', $coreTeamPositionEditFormOTO->getMemberOptions())
            ->setRequired('messages.ctpos.memberRequired');
        $form->addTextArea(CoreTeamPositionMetadata::$description, 'messages.ctpos.description')
            ->setOption('description', 'messages.ctpos.descriptionDescription')
            ->setNullable();

        $form->addSubmit('submit', 'messages.common.submit');

        return $form;
    }

    public function handleEditCoreTeamPositionFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $replacedValues[CoreTeamPositionMetadata::$eventId] = intval($replacedValues[CoreTeamPositionMetadata::$eventId]);
        $replacedValues[CoreTeamPositionMetadata::$coreTeamPositionId] = intval($replacedValues[CoreTeamPositionMetadata::$coreTeamPositionId]);
        $coreTeamPositionId = $this->eventFacade->updateCoreTeamPosition($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.editSuccess"), 'success');
        $this->redirect('Event:detail', $replacedValues[CoreTeamPositionMetadata::$eventId]);
    }

    public function handleCreateCoreTeamPositionFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $coreTeamPositionId = $this->eventFacade->addCoreTeamPosition($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.createSuccess"), 'success');
        $this->redirect('Event:detail', $replacedValues[CoreTeamPositionMetadata::$eventId]);
    }

    public function actionEdit(int $coreTeamPositionId)
    {
        $eventArray = $this->eventFacade->getCoreTeamPositionForForm($coreTeamPositionId);
        $this['coreTeamPositionForm']->setDefaults($eventArray);
        $this['coreTeamPositionForm']->onSuccess[] = array($this, 'handleEditCoreTeamPositionFormSubmit');
    }

    public function actionCreate(int $eventId)
    {
        $this['coreTeamPositionForm']->setDefaults(array(CoreTeamPositionMetadata::$eventId => $eventId));
        $this['coreTeamPositionForm']->onSuccess[] = array($this, 'handleCreateCoreTeamPositionFormSubmit');
    }
}