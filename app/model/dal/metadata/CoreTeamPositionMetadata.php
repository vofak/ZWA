<?php


namespace App\model\dal\metadata;

/**
 * Class CoreTeamPositionMetadata
 *
 * Metadata concerning the Core Team Position database table
 *
 * @package App\model\dal\metadata
 */
class CoreTeamPositionMetadata
{
    public static string $tableName = "ct_position";

    public static string $coreTeamPositionId = "id_ct_pos";
    public static string $eventId = "id_event";
    public static string $memberId = "id_member";
    public static string $name = "name";
    public static string $description = "description";
}