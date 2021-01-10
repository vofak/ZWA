<?php

declare(strict_types=1);


namespace App\Presenters;


use App\model\dal\metadata\EventMetadata;
use App\model\facade\event\EventFacade;
use App\model\templating\BootstrapForm;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Form;

/**
 * Class EventPresenter
 * @package App\Presenters
 */
class EventPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var EventFacade
     */
    public EventFacade $eventFacade;

    public function handleGetEventName(int $eventId) {

        $eventDetailOTO = $this->eventFacade->getEventDetail($eventId);

        $this->sendResponse(new JsonResponse(['name' => $eventDetailOTO->getEventName()]));
    }

    public function handleGetEventList(int $offset, int $limit, string $search) {
        $eventsForView = $this->eventFacade->getEventsForView($offset, $limit, $search);
        // todo optimize
        $count = count($this->eventFacade->getEventsForView(null, null, $search));
        $this->sendJson(['total'=> $count, 'rows'=>$eventsForView]);
    }

    public function renderDetail(int $eventId)
    {
        $this->template->eventDetailOTO = $this->eventFacade->getEventDetail($eventId);
    }

    public function renderList()
    {
        $this->template->eventsForView = $this->eventFacade->getEventsForView();
    }

    protected function createComponentEventForm()
    {
        $eventEditFormOTO = $this->eventFacade->getEventEditForm();

        $form = new BootstrapForm();
        $form->setTranslator($this->translator);

        $form->addGroup('messages.event.basicInfo');

        $form->addHidden(EventMetadata::$eventId);
        $form->addText(EventMetadata::$name, 'messages.event.name')
            ->setRequired('messages.event.nameRequired');
        $form->addText(EventMetadata::$place, 'messages.event.place')
            ->setRequired('messages.event.placeRequired');

        $form->addSelect(EventMetadata::$mainOrganiserId, 'messages.event.mo', $eventEditFormOTO->getMainOrganiserOptions());

        $form->addDate(EventMetadata::$startDate, 'messages.event.startDate')
            ->setRequired('messages.event.dateRequired');
        $form->addDate(EventMetadata::$endDate, 'messages.event.endDate')
            ->setRequired('messages.event.dateRequired');
        $form->addSelect(EventMetadata::$state, "messages.event.state", $eventEditFormOTO->getStateOptions());

        $form->addTextArea(EventMetadata::$facebook, 'messages.event.facebook')
            ->setNullable()
            ->addCondition($form::FILLED)->addRule(Form::URL);

        $form->addSubmit('submit', 'messages.common.submit');

        return $form;
    }

    public function handleEditEventFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $replacedValues[EventMetadata::$eventId] = intval($replacedValues[EventMetadata::$eventId]);
        $eventId = $this->eventFacade->updateEvent($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.editSuccess"), 'success');
        $this->redirect('Event:detail', $eventId);
    }

    public function handleCreateEventFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $eventId = $this->eventFacade->addEvent($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.createSuccess"), 'success');
        $this->redirect('Event:detail', $eventId);
    }

    public function actionEdit(int $eventId)
    {
        $eventArray = $this->eventFacade->getEventForForm($eventId);
        $this['eventForm']->setDefaults($eventArray);
        $this['eventForm'][EventMetadata::$startDate]->setDefaultValue($eventArray[EventMetadata::$startDate]->format("Y-m-d"));
        $this['eventForm'][EventMetadata::$endDate]->setDefaultValue($eventArray[EventMetadata::$endDate]->format("Y-m-d"));
        $this['eventForm']->onSuccess[] = array($this, 'handleEditEventFormSubmit');
    }

    public function actionCreate()
    {
        $this['eventForm']->onSuccess[] = array($this, 'handleCreateEventFormSubmit');
    }

    public function handleDeleteEvent(int $eventId)
    {
        $this->eventFacade->deleteEvent($eventId);
        $this->flashMessage($this->translator->translate('messages.common.deleteSuccess'), 'success');
        $this->redirect('Event:list');
    }

    public function handleDeleteCoreTeamPosition(int $coreTeamPositionId)
    {
        $this->eventFacade->deleteCoreTeamPosition($coreTeamPositionId);
        $this->flashMessage($this->translator->translate('messages.common.deleteSuccess'), 'success');
        $this->redirect('this');
    }

}