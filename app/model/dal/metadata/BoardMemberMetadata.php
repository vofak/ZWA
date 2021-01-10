<?php


namespace App\model\dal\metadata;


/**
 * Class BoardMemberMetadata
 *
 * Metadata concerning the Board Member database table
 *
 * @package App\model\dal\metadata
 */
class BoardMemberMetadata
{
    public static string $tableName = "board_member";

    public static string $boardMemberId = "id_board_member";
    public static string $memberId = "id_member";
    public static string $boardPositionId = "id_board_pos";
    public static string $boardId = "id_board";
    public static string $startDate = "start_date";
    public static string $endDate = "end_date";
}