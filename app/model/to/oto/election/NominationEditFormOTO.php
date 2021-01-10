<?php


namespace App\model\to\oto\election;

/**
 * Class NominationEditFormOTO
 * @package App\model\to\oto\election
 */
class NominationEditFormOTO
{
    private array $boardPositionOptions;
    private array $nomineeOptions;

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

    /**
     * @return array
     */
    public function getNomineeOptions(): array
    {
        return $this->nomineeOptions;
    }

    /**
     * @param array $nomineeOptions
     */
    public function setNomineeOptions(array $nomineeOptions): void
    {
        $this->nomineeOptions = $nomineeOptions;
    }


}