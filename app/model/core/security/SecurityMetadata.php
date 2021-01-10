<?php


namespace App\model\core\security;

/**
 * Class SecurityMetadata
 *
 * Class containing security metadata - resources, roles, actions
 *
 * @package App\model\core\security
 */
class SecurityMetadata
{
    const memberResource = "memberResource";
    const boardResource = "boardResource";
    const eventResource = "eventResource";
    const coreTeamPositionResource = "coreTeamPositionResource";
    const electionResource = "electionResource";

    public static string $adminRole = "admin";
    public static string $memberRole = "member";
    public static string $guestRole = "guest";

    public static string $viewAction = "viewAction";
    public static string $viewSensitiveAction = "viewSensitiveAction";
    public static string $createAction = "createAction";
    public static string $editAction = "editAction";
    public static string $editSensitiveAction = "editSensitiveAction";
    public static string $editCoreTeamAction = "editCoreTeam";
    public static string $deleteAction = "deleteAction";
}