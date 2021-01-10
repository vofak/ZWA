<?php

declare(strict_types=1);


namespace App\model\dal\dao\common;

use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

/**
 * Class CommonDAO
 *
 * Abstract database access object common for all DAOs
 *
 * @package App\model\dal\dao\common
 */
abstract class CommonDAO
{
    private Context $database;

    public function __construct(Context $database)
    {
        $this->database = $database;
    }

    /**
     * @return Context database context
     */
    protected function getDatabase(): Context
    {
        return $this->database;
    }

    /**
     * Finds a unique row given the selection. Throws an exception when more rows were found or when a row was not
     * found but was expected
     *
     * @param Selection $selection query
     * @param bool $expected indicator whether the
     * @return ActiveRow|null entity object
     */
    protected function findUnique(Selection $selection, bool $expected = false): ?ActiveRow
    {
        if (count($selection) < 1) {
            if ($expected){
                throw new \RuntimeException("Data not found");
            }
            else {
                return null;
            }
        }
        else if (count($selection) > 1) {
            throw new \RuntimeException("Unique data not found");
        }
        return $selection->fetch();
    }

}