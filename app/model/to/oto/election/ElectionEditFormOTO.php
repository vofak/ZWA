<?php


namespace App\model\to\oto\election;

/**
 * Class ElectionEditFormOTO
 * @package App\model\to\oto\election
 */
class ElectionEditFormOTO
{
    private array $boardPositionOptions;

    /**
     * @return array
     */
    public function getBoardPositionOptions(): array
    {
        return $this->boardPositionOptions;
    }

    /**
     * @param array $boardPositionOptions
     */
    public function setBoardPositionOptions(array $boardPositionOptions): void
    {
        $this->boardPositionOptions = $boardPositionOptions;
    }


}