<?php


namespace App\model\dal\metadata;

/**
 * Class RankMetadata
 *
 * Metadata concerning the Rank database table
 *
 * @package App\model\dal\metadata
 */
class RankMetadata
{
    public static string $tableName = "member_rank";

    public static string $rankId = "id_rank";
    public static string $name = "name";
    public static string $hasVotingRight = "voting_right";
    public static string $hasAccessRight = "access_right";
    public static string $hasNominationRight = "nomination_right";
    public static string $hasCandidateRight = "candidate_right";
    public static string $isActive = "active";
}