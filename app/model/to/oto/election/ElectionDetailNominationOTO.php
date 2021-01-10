<?php


namespace App\model\to\oto\election;

/**
 * Class ElectionDetailNominationOTO
 * @package App\model\to\oto\election
 */
class ElectionDetailNominationOTO
{
    private string $boardPositionName;
    private int $count;
    private array $descriptions;

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
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return array
     */
    public function getDescriptions(): array
    {
        return $this->descriptions;
    }

    /**
     * @param array $descriptions
     */
    public function setDescriptions(array $descriptions): void
    {
        $this->descriptions = $descriptions;
    }


}