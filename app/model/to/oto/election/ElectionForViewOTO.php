<?php


namespace App\model\to\oto\election;

use DateTime;

/**
 * Class ElectionForViewOTO
 * @package App\model\to\oto\election
 */
class ElectionForViewOTO
{
    private int $electionId;
    private string $name;
    private bool $published;
    private DateTime $startDate;
    private DateTime $endDate;

    /**
     * @return int
     */
    public function getElectionId(): int
    {
        return $this->electionId;
    }

    /**
     * @param int $electionId
     */
    public function setElectionId(int $electionId): void
    {
        $this->electionId = $electionId;
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
     * @return bool
     */
    public function getPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }


}