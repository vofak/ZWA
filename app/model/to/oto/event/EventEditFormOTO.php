<?php


namespace App\model\to\oto\event;

/**
 * Class EventEditFormOTO
 * @package App\model\to\oto\event
 */
class EventEditFormOTO
{
    private array $mainOrganiserOptions;
    private array $stateOptions;

    /**
     * @return array
     */
    public function getMainOrganiserOptions(): array
    {
        return $this->mainOrganiserOptions;
    }

    /**
     * @param array $mainOrganiserOptions
     */
    public function setMainOrganiserOptions(array $mainOrganiserOptions): void
    {
        $this->mainOrganiserOptions = $mainOrganiserOptions;
    }

    /**
     * @return array
     */
    public function getStateOptions(): array
    {
        return $this->stateOptions;
    }

    /**
     * @param array $stateOptions
     */
    public function setStateOptions(array $stateOptions): void
    {
        $this->stateOptions = $stateOptions;
    }

}