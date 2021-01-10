<?php


namespace App\model\dal\metadata;

/**
 * Class ElectionBoardPositionMetadata
 *
 * Metadata concerning the Election Board Position database table
 *
 * @package App\model\dal\metadata
 */
class ElectionBoardPositionMetadata
{
    public static string $tableName = "election_board_position";

    public static string $electionBoardPositionId = "id_election_board_position";
    public static string $electionId = "id_election";
    public static string $boardPositionId = "id_board_pos";
}