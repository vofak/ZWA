<?php


namespace App\model\templating;


use Nette\Utils\Json;
use Nette\Utils\JsonException;

/**
 * Class Filters
 *
 * Filters for latte templates
 *
 * @package App\model\templating
 */
class Filters
{
    /**
     * @param $var
     * @return string json format of the input var
     * @throws JsonException
     */
    public static function json($var) {
        return Json::encode($var);
    }
}