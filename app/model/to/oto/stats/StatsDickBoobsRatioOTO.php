<?php


namespace App\model\to\oto\stats;

/**
 * Class StatsDickBoobsRatioOTO
 * @package App\model\to\oto\stats
 */
class StatsDickBoobsRatioOTO
{
    private int $dickRatio;
    private int $boobsRatio;

    /**
     * @return int
     */
    public function getDickRatio(): int
    {
        return $this->dickRatio;
    }

    /**
     * @param int $dickRatio
     */
    public function setDickRatio(int $dickRatio): void
    {
        $this->dickRatio = $dickRatio;
    }

    /**
     * @return int
     */
    public function getBoobsRatio(): int
    {
        return $this->boobsRatio;
    }

    /**
     * @param int $boobsRatio
     */
    public function setBoobsRatio(int $boobsRatio): void
    {
        $this->boobsRatio = $boobsRatio;
    }
}