<?php

declare(strict_types=1);


namespace App\model\to\oto\member;

use DateTime;

/**
 * Class MemberBoardPositionOTO
 * @package App\model\to\oto\member
 */
class MemberBoardPositionOTO
{
    private int $boardId;
    private string $boardName;
    private int $boardPositionId;
    private string $boardPositionName;
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
     * @return string
     */
    public function getBoardPositionName(): string
    {
        return $this->boardPositionName;
    }

    /**
     * @param string $boardPositionName
     */
    public function setBoardPositionName(string $boardPositionName): void
    {
        $this->boardPositionName = $boardPositionName;
    }

    /**
     * @return int
     */
    public function getBoardPositionId(): int
    {
        return $this->boardPositionId;
    }

    /**
     * @param int $boardPositionId
     */
    public function setBoardPositionId(int $boardPositionId): void
    {
        $this->boardPositionId = $boardPositionId;
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