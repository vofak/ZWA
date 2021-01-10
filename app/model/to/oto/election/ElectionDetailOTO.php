<?php


namespace App\model\to\oto\election;

/**
 * Class ElectionDetailOTO
 * @package App\model\to\oto\election
 */
class ElectionDetailOTO
{
    private string $electionName;
    private array $nominations;

    /**
     * @return string
     */
    public function getElectionName(): string
    {
        return $this->electionName;
    }

    /**
     * @param string $electionName
     */
    public function setElectionName(string $electionName): void
    {
        $this->electionName = $electionName;
    }

    /**
     * @return array
     */
    public function getNominations(): array
    {
        return $this->nominations;
    }

    /**
     * @param array $nominations
     */
    public function setNominations(array $nominations): void
    {
        $this->nominations = $nominations;
    }


}