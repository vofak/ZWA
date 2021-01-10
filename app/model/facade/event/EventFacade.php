<?php

declare(strict_types=1);


namespace App\model\facade\event;


use App\model\common\EventState;
use App\model\common\utils\MemberUtils;
use App\model\core\security\resource\EventResource;
use App\model\core\security\SecurityMetadata;
use App\model\core\security\SecurityResolver;
use App\model\dal\dao\EventDAO;
use App\model\dal\dao\MemberDAO;
use App\model\dal\metadata\CoreTeamPositionMetadata;
use App\model\dal\metadata\EventMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\facade\common\CommonFacade;
use App\model\to\oto\event\CoreTeamPositionEditFormOTO;
use App\model\to\oto\event\EventCoreTeamPositionOTO;
use App\model\to\oto\event\EventDetailOTO;
use App\model\to\oto\event\EventEditFormOTO;
use App\model\to\oto\event\EventForViewOTO;
use Exception;
use Laminas\EventManager\Event;
use Nette\Security\User;

/**
 * Class EventFacade
 *
 * Component handling event related stuff in service layer
 *
 * @package App\model\facade\event
 */
class EventFacade extends CommonFacade
{
    private EventDAO $eventDAO;
    private MemberDAO $memberDAO;

    private EventTOFiller $eventTOFiller;

    /**
     * EventFacade constructor.
     *
     * @param EventDAO $eventDAO
     * @param MemberDAO $memberDAO
     * @param EventTOFiller $eventTOFiller
     * @param User $user
     * @param SecurityResolver $securityResolver
     */
    public function __construct(EventDAO $eventDAO, MemberDAO $memberDAO, EventTOFiller $eventTOFiller, User $user, SecurityResolver $securityResolver)
    {
        parent::__construct($user, $securityResolver);
        $this->eventDAO = $eventDAO;
        $this->memberDAO = $memberDAO;
        $this->eventTOFiller = $eventTOFiller;
    }

    # EVENT

    /**
     * @param int $eventId event id
     * @return EventDetailOTO OTO with info about a single event
     * @throws Exception
     */
    public function getEventDetail(int $eventId): EventDetailOTO
    {
        $eventEO = $this->eventDAO->getEvent($eventId);
        $eventResource = new EventResource($eventEO);
        $this->checkPermission($eventResource, SecurityMetadata::$viewAction);

        $coreTeamPositionEOs = $eventEO->related(CoreTeamPositionMetadata::$tableName, CoreTeamPositionMetadata::$eventId);

        $coreTeamPositions = array();
        if (!is_null($eventEO[EventMetadata::$mainOrganiserId])){
            $mainOrganiserMemberEO = $eventEO->ref(MemberMetadata::$tableName, EventMetadata::$mainOrganiserId);
            $mainOrganiser = $this->eventTOFiller->fillEventCoreTeamPosition(new EventCoreTeamPositionOTO(), null, "Main Organiser", $mainOrganiserMemberEO);
            $coreTeamPositions[] = $mainOrganiser;
        }
        foreach ($coreTeamPositionEOs as $coreTeamPositionEO) {
            $memberEO = $coreTeamPositionEO->ref(MemberMetadata::$tableName, CoreTeamPositionMetadata::$memberId);
            $coreTeamPositionOTO = $this->eventTOFiller->fillEventCoreTeamPosition(new EventCoreTeamPositionOTO(), $coreTeamPositionEO[CoreTeamPositionMetadata::$coreTeamPositionId], $coreTeamPositionEO[CoreTeamPositionMetadata::$name], $memberEO);
            $coreTeamPositions[] = $coreTeamPositionOTO;
        }

        $editEventPermissionLevel = $this->resolvePermissionLevel($eventResource, SecurityMetadata::$editAction);
        $deleteEventPermissionLevel = $this->resolvePermissionLevel($eventResource, SecurityMetadata::$deleteAction);
        $editCoreTeamPermissionLevel = $this->resolvePermissionLevel($eventResource, SecurityMetadata::$editCoreTeamAction);


        $eventOTO = $this->eventTOFiller->fillEventDetail(new EventDetailOTO(), $eventEO, $coreTeamPositions, $editEventPermissionLevel, $deleteEventPermissionLevel, $editCoreTeamPermissionLevel);
        return $eventOTO;
    }

    /**
     * @param int|null $offset offset
     * @param int|null $limit limit
     * @param string|null $search search string
     * @return array basic info about all events
     * @throws Exception
     */
    public function getEventsForView($offset=null, $limit=null, $search=null): array
    {
        $this->checkPermission(SecurityMetadata::eventResource, SecurityMetadata::$viewAction);

        $events = $this->eventDAO->getEvents($offset, $limit, $search);

        $eventsForView = array();
        foreach ($events as $eventEO) {
            $eventForView = $this->eventTOFiller->fillEventForView(new EventForViewOTO(), $eventEO);
            $eventsForView[] = $eventForView;
        }
        return $eventsForView;
    }

    /**
     * @param int $eventId event id
     * @return array default values for event edit form
     */
    public function getEventForForm(int $eventId): array
    {
        $eventEO = $this->eventDAO->getEvent($eventId);
        return $eventEO->toArray();
    }

    /**
     * @return EventEditFormOTO info for the event edit/create form
     */
    public function getEventEditForm(): EventEditFormOTO
    {
        $mainOrganiserOptions = array();
        $memberEOs = $this->memberDAO->getMembers();
        $mainOrganiserOptions[null] = '-';
        foreach ($memberEOs as $memberEO) {
            $memberId = $memberEO[MemberMetadata::$memberId];
            $mainOrganiserOptions[$memberId] = MemberUtils::resolveDisplayName($memberEO);
        }

        $stateOptions = array(
            EventState::planned => "Planned",
            EventState::running => "Running",
            EventState::finished => "Finished",
            EventState::canceled => "Canceled",
        );

        $eventEditFormOTO = $this->eventTOFiller->fillEventEditFormOTO(new EventEditFormOTO(), $mainOrganiserOptions, $stateOptions);
        return $eventEditFormOTO;
    }

    /**
     * @param array $eventArray event array to be added
     * @return int id of the added event
     * @throws Exception
     */
    public function addEvent(array $eventArray): int
    {
        $this->checkPermission(SecurityMetadata::eventResource, SecurityMetadata::$createAction);

        $eventEO = $this->eventDAO->insertEvent($eventArray);
        return $eventEO[EventMetadata::$eventId];
    }

    /**
     * @param array $eventArray event array to be updated
     * @return int id of the updated event
     * @throws Exception
     */
    public function updateEvent(array $eventArray): int
    {
        $this->checkPermission(SecurityMetadata::eventResource, SecurityMetadata::$createAction);

        $eventId = $eventArray[EventMetadata::$eventId];
        $eventEO = $this->eventDAO->getEvent($eventId);
        $eventEO->update($eventArray);
        return $eventId;
    }

    /**
     * @param int $eventId event id
     * @throws Exception
     */
    public function deleteEvent(int $eventId)
    {
        $this->checkPermission(SecurityMetadata::eventResource, SecurityMetadata::$deleteAction);

        $this->eventDAO->deleteEvent($eventId);
    }

    # CORE TEAM POSITION

    /**
     * @return CoreTeamPositionEditFormOTO info for the CT position edit/create form
     */
    public function getCoreTeamPositionEditForm(): CoreTeamPositionEditFormOTO
    {
        $memberOptions = array();
        $memberEOs = $this->memberDAO->getMembers();
        $memberOptions[null] = '-';
        foreach ($memberEOs as $memberEO) {
            $memberId = $memberEO[MemberMetadata::$memberId];
            $memberOptions[$memberId] = MemberUtils::resolveDisplayName($memberEO);
        }

        $memberEditFormOTO = $this->eventTOFiller->fillCoreTeamPositionEditFormOTO(new CoreTeamPositionEditFormOTO(), $memberOptions);
        return $memberEditFormOTO;
    }

    /**
     * @param int $coreTeamPositionId core team position id
     * @return array default values for CT position edit form
     * @throws Exception
     */
    public function getCoreTeamPositionForForm(int $coreTeamPositionId): array
    {
        $this->checkPermission(SecurityMetadata::coreTeamPositionResource, SecurityMetadata::$viewAction);

        $coreTeamPositionEO = $this->eventDAO->getCoreTeamPosition($coreTeamPositionId);
        return $coreTeamPositionEO->toArray();
    }

    /**
     * @param array $coreTeamPositionArray core team position array to be added
     * @return int id of the added core team position
     * @throws Exception
     */
    public function addCoreTeamPosition(array $coreTeamPositionArray): int
    {
        $eventId = $coreTeamPositionArray[CoreTeamPositionMetadata::$eventId];
        $eventEO = $this->eventDAO->getEvent($eventId);
        $eventResource = new EventResource($eventEO);
        $this->checkPermission($eventResource, SecurityMetadata::$editCoreTeamAction);

        $coreTeamPositionEO = $this->eventDAO->insertCoreTeamPosition($coreTeamPositionArray);
        return $coreTeamPositionEO[CoreTeamPositionMetadata::$coreTeamPositionId];
    }

    /**
     * @param array $coreTeamPositionArray core team position to be updated
     * @return int id of the updated core team position
     * @throws Exception
     */
    public function updateCoreTeamPosition(array $coreTeamPositionArray): int
    {
        $coreTeamPositionId = $coreTeamPositionArray[CoreTeamPositionMetadata::$coreTeamPositionId];
        $coreTeamPositionEO = $this->eventDAO->getCoreTeamPosition($coreTeamPositionId);
        $eventEO = $coreTeamPositionEO->ref(EventMetadata::$tableName, CoreTeamPositionMetadata::$eventId);
        $eventResource = new EventResource($eventEO);
        $this->checkPermission($eventResource, SecurityMetadata::$editCoreTeamAction);

        $coreTeamPositionEO->update($coreTeamPositionArray);
        return $coreTeamPositionId;
    }

    /**
     * @param int $coreTeamPositionId core team position id
     * @throws Exception
     */
    public function deleteCoreTeamPosition(int $coreTeamPositionId)
    {
        $coreTeamPositionEO = $this->eventDAO->getCoreTeamPosition($coreTeamPositionId);
        $eventEO = $coreTeamPositionEO->ref(EventMetadata::$tableName, CoreTeamPositionMetadata::$eventId);
        $eventResource = new EventResource($eventEO);
        $this->checkPermission($eventResource, SecurityMetadata::$editCoreTeamAction);

        $this->eventDAO->deleteCoreTeamPosition($coreTeamPositionId);
    }
}