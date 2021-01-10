<?php


namespace App\model\to\oto\stats;

/**
 * Class StatsDataOTO
 * @package App\model\to\oto\stats
 */
class StatsDataOTO
{
    private array $labels;
    private array $data;

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     */
    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

}