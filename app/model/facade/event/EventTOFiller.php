<?php

declare(strict_types=1);


namespace App\model\facade\event;


use App\model\common\utils\MemberUtils;
use App\model\dal\metadata\BoardMetadata;
use App\model\dal\metadata\CoreTeamPositionMetadata;
use App\model\dal\metadata\EventMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\to\oto\event\CoreTeamPositionEditFormOTO;
use App\model\to\oto\event\EventCoreTeamPositionOTO;
use App\model\to\oto\event\EventDetailOTO;
use App\model\to\oto\event\EventEditFormOTO;
use App\model\to\oto\event\EventForViewOTO;
use App\model\to\oto\event\EventOTO;
use Nette\Database\Table\ActiveRow;

/**
 * Class EventTOFiller
 *
 * Component filling event related transfer objects
 *
 * @package App\model\facade\event
 */
class EventTOFiller
{
    private function fillEvent(EventOTO $eventOTO, ActiveRow $eventEO): EventOTO
    {
        $eventOTO->setEventId($eventEO[EventMetadata::$eventId]);
        $eventOTO->setEventName($eventEO[EventMetadata::$name]);
        $eventOTO->setPlace($eventEO[EventMetadata::$place]);
        $eventOTO->setStartDate($eventEO[EventMetadata::$startDate]);
        $eventOTO->setEndDate($eventEO[EventMetadata::$endDate]);


        return $eventOTO;
    }


    public function fillEventDetail(EventDetailOTO $eventDetailOTO, ActiveRow $eventEO, array $coreTeamPositions, string $editEventPermissionLevel, string $deleteEventPermissionLevel, string $editCoreTeamPermissionLevel): EventDetailOTO
    {
        $this->fillEvent($eventDetailOTO, $eventEO);

        $eventDetailOTO->setCoreTeamPositions($coreTeamPositions);
        $eventDetailOTO->setState($eventEO[EventMetadata::$state]);
        $eventDetailOTO->setEditEventPermissionLevel($editEventPermissionLevel);
        $eventDetailOTO->setDeleteEventPermissionLevel($deleteEventPermissionLevel);
        $eventDetailOTO->setEditCoreTeamPermissionLevel($editCoreTeamPermissionLevel);

        return $eventDetailOTO;
    }

    public function fillEventCoreTeamPosition(EventCoreTeamPositionOTO $coreTeamPositionOTO, ?int $coreTeamPositionId, string $coreTeamPositionName, ActiveRow $memberEO): EventCoreTeamPositionOTO
    {
        $coreTeamPositionOTO->setCoreTeamPositionId($coreTeamPositionId);
        $coreTeamPositionOTO->setCoreTeamPositionName($coreTeamPositionName);
        $coreTeamPositionOTO->setMemberId($memberEO[MemberMetadata::$memberId]);
        $coreTeamPositionOTO->setName(MemberUtils::resolveDisplayName($memberEO));

        return $coreTeamPositionOTO;
    }

    public function fillEventForView(EventForViewOTO $eventForViewOTO, ActiveRow $eventEO): EventForViewOTO
    {
        $this->fillEvent($eventForViewOTO, $eventEO);

        return $eventForViewOTO;
    }

    public function fillEventEditFormOTO(EventEditFormOTO $eventEditFormOTO, array $mainOrganiserOptions, array $stateOptions): EventEditFormOTO
    {
        $eventEditFormOTO->setMainOrganiserOptions($mainOrganiserOptions);
        $eventEditFormOTO->setStateOptions($stateOptions);

        return $eventEditFormOTO;
    }

    public function fillCoreTeamPositionEditFormOTO(CoreTeamPositionEditFormOTO $coreTeamPositionEditFormOTO, array $memberOptions)
    {
        $coreTeamPositionEditFormOTO->setMemberOptions($memberOptions);

        return $coreTeamPositionEditFormOTO;
    }
}