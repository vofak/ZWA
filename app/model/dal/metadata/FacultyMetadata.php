<?php


namespace App\model\dal\metadata;

/**
 * Class FacultyMetadata
 *
 * Metadata concerning the Faculty database table
 *
 * @package App\model\dal\metadata
 */
class FacultyMetadata
{
    public static string $tableName = "faculty";

    public static string $facultyId = "id_faculty";
    public static string $name = "name";
    public static string $shortName = "shortcut";
}