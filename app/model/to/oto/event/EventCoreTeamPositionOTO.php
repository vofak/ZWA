<?php

declare(strict_types=1);


namespace App\model\to\oto\event;

/**
 * Class EventCoreTeamPositionOTO
 * @package App\model\to\oto\event
 */
class EventCoreTeamPositionOTO
{
    private int $memberId;
    private string $name;
    private ?int $coreTeamPositionId = null;
    private string $coreTeamPositionName;

    /**
     * @return int
     */
    public function getMemberId(): int
    {
        return $this->memberId;
    }

    /**
     * @param int $memberId
     */
    public function setMemberId(int $memberId): void
    {
        $this->memberId = $memberId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

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


}