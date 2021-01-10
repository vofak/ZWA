<?php


namespace App\model\to\oto\board;


use DateTime;

/**
 * Class BoardOTO
 * @package App\model\to\oto\board
 */
abstract class BoardOTO
{
    private int $boardId;
    private int $boardNumber;
    private string $boardName;
    private DateTime $startDate;
    private DateTime $endDate;

    /**
     * @return int
     */
    public function getBoardId(): int
    {
        return $this->boardId;
    }

    /**
     * @param int $boardId
     */
    public function setBoardId(int $boardId): void
    {
        $this->boardId = $boardId;
    }

    /**
     * @return int
     */
    public function getBoardNumber(): int
    {
        return $this->boardNumber;
    }

    /**
     * @param int $boardNumber
     */
    public function setBoardNumber(int $boardNumber): void
    {
        $this->boardNumber = $boardNumber;
    }

    /**
     * @return string
     */
    public function getBoardName(): string
    {
        return $this->boardName;
    }

    /**
     * @param string $boardName
     */
    public function setBoardName(string $boardName): void
    {
        $this->boardName = $boardName;
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