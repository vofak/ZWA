<?php

declare(strict_types=1);


namespace App\model\to\oto\board;


use DateTime;

/**
 * Class BoardDetailBoardMemberOTO
 * @package App\model\to\oto\board
 */
class BoardDetailBoardMemberOTO
{
    private int $memberId;
    private string $name;
    private string $boardPositionName;
    private string $imageSrcPath;
    private ?DateTime $startDate;
    private ?DateTime $endDate;

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
     * @return string
     */
    public function getImageSrcPath(): string
    {
        return $this->imageSrcPath;
    }

    /**
     * @param string $imageSrcPath
     */
    public function setImageSrcPath(string $imageSrcPath): void
    {
        $this->imageSrcPath = $imageSrcPath;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime|null $startDate
     */
    public function setStartDate(?DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime|null $endDate
     */
    public function setEndDate(?DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }
}