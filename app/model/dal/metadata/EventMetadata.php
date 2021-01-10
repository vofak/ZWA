<?php


namespace App\model\dal\metadata;

/**
 * Class EventMetadata
 *
 * Metadata concerning the Event database table
 *
 * @package App\model\dal\metadata
 */
class EventMetadata
{
    public static string $tableName = "event";

    public static string $eventId = "id_event";
    public static string $name = "name";
    public static string $mainOrganiserId = "mo_id";
    public static string $place = "place";
    public static string $startDate = "start_date";
    public static string $endDate = "end_date";
    public static string $facebook = "facebook";
    public static string $state = "state";
}