<?php


namespace App\model\dal\metadata;

/**
 * Class MemberMetadata
 *
 * Metadata concerning the Member database table
 *
 * @package App\model\dal\metadata
 */
class MemberMetadata
{
    public static string $tableName = "member";

    public static string $memberId = "id_member";
    public static string $firstName = "name";
    public static string $lastName = "surname";
    public static string $nickname = "nickname";
    public static string $email = "email";
    public static string $birthday = "birthday";
    public static string $joinedDate = "joined";
    public static string $rankId = "id_rank";
    public static string $angelId = "id_angel";
    public static string $phoneNumber = "telephone";
    public static string $facebook = "fb";
    public static string $skype = "skype";
    public static string $shirtSize = "tshirt";
    public static string $role = "role";
    public static string $gender = "gender";
    public static string $trello = "trello_username";
    public static string $googleId = "google_id";
    public static string $googleImage = "google_image";
    public static string $languageId = "id_language";
    public static string $workingGroupId = "id_wg";
    public static string $facultyId = "id_faculty";
}