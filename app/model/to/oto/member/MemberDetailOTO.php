<?php

declare(strict_types=1);


namespace App\model\to\oto\member;

/**
 * Class MemberDetailOTO
 * @package App\model\to\oto\member
 */
class MemberDetailOTO extends MemberOTO
{
    private array $coreTeamPositions;
    private array $boardPositions;
    private string $editPermissionLevel;
    private string $deletePermissionLevel;

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
     * @return array
     */
    public function getBoardPositions(): array
    {
        return $this->boardPositions;
    }

    /**
     * @param array $boardPositions
     */
    public function setBoardPositions(array $boardPositions): void
    {
        $this->boardPositions = $boardPositions;
    }

    /**
     * @return string
     */
    public function getEditPermissionLevel(): string
    {
        return $this->editPermissionLevel;
    }

    /**
     * @param string $editPermissionLevel
     */
    public function setEditPermissionLevel(string $editPermissionLevel): void
    {
        $this->editPermissionLevel = $editPermissionLevel;
    }

    /**
     * @return string
     */
    public function getDeletePermissionLevel(): string
    {
        return $this->deletePermissionLevel;
    }

    /**
     * @param string $deletePermissionLevel
     */
    public function setDeletePermissionLevel(string $deletePermissionLevel): void
    {
        $this->deletePermissionLevel = $deletePermissionLevel;
    }

}