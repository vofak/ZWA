<?php


namespace App\model\facade\stats;


use App\model\to\oto\stats\StatsDataOTO;
use App\model\to\oto\stats\StatsDickBoobsRatioOTO;
use App\model\to\oto\stats\StatsGenderedDataOTO;

/**
 * Class StatsTOFiller
 *
 * Component filling stats related transfer objects
 *
 * @package App\model\facade\stats
 */
class StatsTOFiller
{

    public function fillStatsGenderedData(StatsGenderedDataOTO $statsGenderedDataOTO, array $labels, array $maleData, array $femaleData): StatsGenderedDataOTO
    {
        $statsGenderedDataOTO->setLabels($labels);
        $statsGenderedDataOTO->setMaleData($maleData);
        $statsGenderedDataOTO->setFemaleData($femaleData);

        return $statsGenderedDataOTO;
    }

    public function fillStatsData(StatsDataOTO $statsDataOTO, array $labels, array $data): StatsDataOTO
    {
        $statsDataOTO->setLabels($labels);
        $statsDataOTO->setData($data);

        return $statsDataOTO;
    }

    public function fillStatsDickBoobsRatio(StatsDickBoobsRatioOTO $statsDickBoobsRatioOTO, int $dickRatio, int $boobsRatio): StatsDickBoobsRatioOTO
    {
        $statsDickBoobsRatioOTO->setDickRatio($dickRatio);
        $statsDickBoobsRatioOTO->setBoobsRatio($boobsRatio);

        return $statsDickBoobsRatioOTO;
    }
}