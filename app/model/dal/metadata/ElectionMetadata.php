<?php


namespace App\model\dal\metadata;

/**
 * Class ElectionMetadata
 *
 * Metadata concerning the Election database table
 *
 * @package App\model\dal\metadata
 */
class ElectionMetadata
{
    public static string $tableName = "election";

    public static string $electionId = "id_election";
    public static string $name = "name";
    public static string $boardId = "id_board";
    public static string $startDate = "start_date";
    public static string $endDate = "end_date";
    public static string $isPublished = "published";
}