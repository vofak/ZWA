<?php


namespace App\model\dal\metadata;

/**
 * Class LanguageMetadata
 *
 * Metadata concerning the Language database table
 *
 * @package App\model\dal\metadata
 */
class LanguageMetadata
{
    public static string $tableName = "language";

    public static string $languageId = "id_language";
    public static string $iso2 = "iso_2";
}