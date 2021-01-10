<?php


namespace App\model\to\oto\board;

/**
 * Class BoardEditFormOTO
 * @package App\model\to\oto\board
 */
class BoardEditFormOTO
{
    private array $boardPositions;
    private array $memberOptions;

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
     * @return array
     */
    public function getMemberOptions(): array
    {
        return $this->memberOptions;
    }

    /**
     * @param array $memberOptions
     */
    public function setMemberOptions(array $memberOptions): void
    {
        $this->memberOptions = $memberOptions;
    }


}