<?php


namespace App\model\to\ito;

use DateTime;

/**
 * Class BoardUpdateITO
 *
 * Input transfer object representing update of a board entity and positions in that board
 *
 * @package App\model\to\ito
 */
class BoardUpdateITO
{
    private ?int $boardId;
    private int $boardNumber;
    private string $boardName;
    private DateTime $startDate;
    private DateTime $endDate;
    private array $boardMembers;

    /**
     * @return int|null
     */
    public function getBoardId(): ?int
    {
        return $this->boardId;
    }

    /**
     * @param int|null $boardId
     */
    public function setBoardId(?int $boardId): void
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

    /**
     * @return array
     */
    public function getBoardMembers(): array
    {
        return $this->boardMembers;
    }

    /**
     * @param array $boardMembers
     */
    public function setBoardMembers(array $boardMembers): void
    {
        $this->boardMembers = $boardMembers;
    }

}