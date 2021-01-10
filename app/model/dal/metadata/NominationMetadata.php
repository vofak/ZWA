<?php


namespace App\model\dal\metadata;

/**
 * Class NominationMetadata
 *
 * Metadata concerning the Nomination database table
 *
 * @package App\model\dal\metadata
 */
class NominationMetadata
{
    public static string $tableName = "nomination";

    public static string $nominationId = "id_nomination";
    public static string $electionId = "id_election";
    public static string $proposerId = "id_proposer";
    public static string $nomineeId = "id_nominee";
    public static string $boardPositionId = "id_board_pos";
    public static string $note = "note";
}