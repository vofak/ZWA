<?php


namespace App\model\dal\metadata;

/**
 * Class WorkingGroupMetadata
 *
 * Metadata concerning the Working Group database table
 *
 * @package App\model\dal\metadata
 */
class WorkingGroupMetadata
{
    public static string $tableName = "working_group";

    public static string $workingGroupId = "id_working_group";
    public static string $name = "name";
    public static string $shortName = "shortcut";
}