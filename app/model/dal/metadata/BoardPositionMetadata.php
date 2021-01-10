<?php


namespace App\model\dal\metadata;

/**
 * Class BoardPositionMetadata
 *
 * Metadata concerning the Board Position database table
 *
 * @package App\model\dal\metadata
 */
class BoardPositionMetadata
{
    public static string $tableName = "board_position";

    public static string $boardPositionId = "id_board_position";
    public static string $name = "name";
    public static string $isExecutive = "executive";
}