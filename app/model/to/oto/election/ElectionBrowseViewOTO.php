<?php


namespace App\model\to\oto\election;

/**
 * Class ElectionBrowseViewOTO
 * @package App\model\to\oto\election
 */
class ElectionBrowseViewOTO
{
    private array $electionForViewOTOs;
    private string $deleteElectionPermissionLevel;
    private string $editElectionPermissionLevel;
    private string $createElectionPermissionLevel;

    /**
     * @return array
     */
    public function getElectionForViewOTOs(): array
    {
        return $this->electionForViewOTOs;
    }

    /**
     * @param array $electionForViewOTOs
     */
    public function setElectionForViewOTOs(array $electionForViewOTOs): void
    {
        $this->electionForViewOTOs = $electionForViewOTOs;
    }

    /**
     * @return string
     */
    public function getDeleteElectionPermissionLevel(): string
    {
        return $this->deleteElectionPermissionLevel;
    }

    /**
     * @param string $deleteElectionPermissionLevel
     */
    public function setDeleteElectionPermissionLevel(string $deleteElectionPermissionLevel): void
    {
        $this->deleteElectionPermissionLevel = $deleteElectionPermissionLevel;
    }

    /**
     * @return string
     */
    public function getEditElectionPermissionLevel(): string
    {
        return $this->editElectionPermissionLevel;
    }

    /**
     * @param string $editElectionPermissionLevel
     */
    public function setEditElectionPermissionLevel(string $editElectionPermissionLevel): void
    {
        $this->editElectionPermissionLevel = $editElectionPermissionLevel;
    }

    /**
     * @return string
     */
    public function getCreateElectionPermissionLevel(): string
    {
        return $this->createElectionPermissionLevel;
    }

    /**
     * @param string $createElectionPermissionLevel
     */
    public function setCreateElectionPermissionLevel(string $createElectionPermissionLevel): void
    {
        $this->createElectionPermissionLevel = $createElectionPermissionLevel;
    }
}