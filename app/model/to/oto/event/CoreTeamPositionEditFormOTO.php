<?php


namespace App\model\to\oto\event;

/**
 * Class CoreTeamPositionEditFormOTO
 * @package App\model\to\oto\event
 */
class CoreTeamPositionEditFormOTO
{
    private array $memberOptions;

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