<?php

declare(strict_types=1);


namespace App\model\to\oto\member;


use Nette\Utils\DateTime;

/**
 * Class MemberCoreTeamPositionOTO
 * @package App\model\to\oto\member
 */
class MemberCoreTeamPositionOTO
{
    private ?int $coreTeamPositionId;
    private string $coreTeamPositionName;
    private int $eventId;
    private string $eventName;
    private DateTime $eventStartDate;
    private DateTime $eventEndDate;

    /**
     * @return int|null
     */
    public function getCoreTeamPositionId(): ?int
    {
        return $this->coreTeamPositionId;
    }

    /**
     * @param int|null $coreTeamPositionId
     */
    public function setCoreTeamPositionId(?int $coreTeamPositionId): void
    {
        $this->coreTeamPositionId = $coreTeamPositionId;
    }

    /**
     * @return string
     */
    public function getCoreTeamPositionName(): string
    {
        return $this->coreTeamPositionName;
    }

    /**
     * @param string $coreTeamPositionName
     */
    public function setCoreTeamPositionName(string $coreTeamPositionName): void
    {
        $this->coreTeamPositionName = $coreTeamPositionName;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     */
    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    /**
     * @return DateTime
     */
    public function getEventStartDate(): DateTime
    {
        return $this->eventStartDate;
    }

    /**
     * @param DateTime $eventStartDate
     */
    public function setEventStartDate(DateTime $eventStartDate): void
    {
        $this->eventStartDate = $eventStartDate;
    }

    /**
     * @return DateTime
     */
    public function getEventEndDate(): DateTime
    {
        return $this->eventEndDate;
    }

    /**
     * @param DateTime $eventEndDate
     */
    public function setEventEndDate(DateTime $eventEndDate): void
    {
        $this->eventEndDate = $eventEndDate;
    }


}