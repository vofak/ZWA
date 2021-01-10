<?php


namespace App\model\to\oto\stats;

/**
 * Class StatsGenderedDataOTO
 * @package App\model\to\oto\stats
 */
class StatsGenderedDataOTO
{
    private array $labels;
    private array $maleData;
    private array $femaleData;

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
    public function getMaleData(): array
    {
        return $this->maleData;
    }

    /**
     * @param array $maleData
     */
    public function setMaleData(array $maleData): void
    {
        $this->maleData = $maleData;
    }

    /**
     * @return array
     */
    public function getFemaleData(): array
    {
        return $this->femaleData;
    }

    /**
     * @param array $femaleData
     */
    public function setFemaleData(array $femaleData): void
    {
        $this->femaleData = $femaleData;
    }

}