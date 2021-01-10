<?php

declare(strict_types=1);


namespace App\model\to\oto\event;

/**
 * Class EventDetailOTO
 * @package App\model\to\oto\event
 */
class EventDetailOTO extends EventOTO
{
    private array $coreTeamPositions;
    private string $state;
    private string $editEventPermissionLevel;
    private string $deleteEventPermissionLevel;
    private string $editCoreTeamPermissionLevel;

    /**
     * @return array
     */
    public function getCoreTeamPositions(): array
    {
        return $this->coreTeamPositions;
    }

    /**
     * @param array $coreTeamPositions
     */
    public function setCoreTeamPositions(array $coreTeamPositions): void
    {
        $this->coreTeamPositions = $coreTeamPositions;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getEditEventPermissionLevel(): string
    {
        return $this->editEventPermissionLevel;
    }

    /**
     * @param string $editEventPermissionLevel
     */
    public function setEditEventPermissionLevel(string $editEventPermissionLevel): void
    {
        $this->editEventPermissionLevel = $editEventPermissionLevel;
    }

    /**
     * @return string
     */
    public function getDeleteEventPermissionLevel(): string
    {
        return $this->deleteEventPermissionLevel;
    }

    /**
     * @param string $deleteEventPermissionLevel
     */
    public function setDeleteEventPermissionLevel(string $deleteEventPermissionLevel): void
    {
        $this->deleteEventPermissionLevel = $deleteEventPermissionLevel;
    }

    /**
     * @return string
     */
    public function getEditCoreTeamPermissionLevel(): string
    {
        return $this->editCoreTeamPermissionLevel;
    }

    /**
     * @param string $editCoreTeamPermissionLevel
     */
    public function setEditCoreTeamPermissionLevel(string $editCoreTeamPermissionLevel): void
    {
        $this->editCoreTeamPermissionLevel = $editCoreTeamPermissionLevel;
    }


}