<?php


namespace App\model\dal\metadata;


/**
 * Class BoardMetadata
 *
 * Metadata concerning the Board database table
 *
 * @package App\model\dal\metadata
 */
class BoardMetadata
{
    public static string $tableName = "board";

    public static string $boardId = "board_id";
    public static string $name = "name";
    public static string $number = "number";
    public static string $startDate = "start_date";
    public static string $endDate = "end_date";
}

