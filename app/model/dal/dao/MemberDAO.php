<?php

declare(strict_types=1);


namespace App\model\dal\dao;


use App\model\dal\dao\common\CommonDAO;
use App\model\dal\metadata\MemberMetadata;
use App\model\dal\metadata\RankMetadata;
use Nette\Database\Table\ActiveRow;

/**
 * Class MemberDAO
 *
 * DAO working with entities concerning the member
 *
 * @package App\model\dal\dao
 */
class MemberDAO extends CommonDAO
{

    /**
     * @param int $memberId member id
     * @return ActiveRow member EO
     */
    public function getMember(int $memberId): ActiveRow
    {
        return $this->getDatabase()
            ->table(MemberMetadata::$tableName)
            ->get($memberId);
    }

    /**
     * @param string $googleId google id
     * @return ActiveRow|null member EO or null
     */
    public function findMemberByGoogleId(string $googleId): ?ActiveRow
    {
        $query = $this->getDatabase()
            ->table(MemberMetadata::$tableName)
            ->where(MemberMetadata::$googleId, $googleId);

        return $this->findUnique($query);
    }

    /**
     * @param string $email email address
     * @return ActiveRow|null member EO or null
     */
    public function findMemberByEmail(string $email): ?ActiveRow
    {
        $query = $this->getDatabase()
            ->table(MemberMetadata::$tableName)
            ->where(MemberMetadata::$email, $email);

        return $this->findUnique($query);
    }

    /**
     * @param int $memberId member id
     */
    public function deleteMember(int $memberId): void
    {
        $this->getDatabase()
            ->table(MemberMetadata::$tableName)
            ->get($memberId)
            ->delete();
    }

    /**
     * @param array $memberArray member array
     * @return ActiveRow inserted member EO
     */
    public function insertMember(array $memberArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(MemberMetadata::$tableName)
            ->insert($memberArray);
    }

    /**
     * @return array array of all existing members
     */
    public function getMembers(): array
    {
        return $this->getDatabase()
            ->table(MemberMetadata::$tableName)
            ->select(MemberMetadata::$tableName . ".*")
            ->order(MemberMetadata::$firstName . " ASC")
            ->fetchAll();

    }

    /**
     * @param bool $active activity indicator
     * @return array array of all members with given activity
     */
    public function getMembersWithActivity(bool $active)
    {
        $activeRanks = $this->getDatabase()
            ->table(RankMetadata::$tableName)
            ->where(RankMetadata::$isActive, $active)
            ->fetchAll();
        $activeMembers = array();
        foreach ($activeRanks as $activeRank) {
            $rankMembers = $activeRank->related(MemberMetadata::$tableName, MemberMetadata::$rankId);
            foreach ($rankMembers as $rankMember) {
                $activeMembers[] = $rankMember;
            }
        }
        return $activeMembers;
    }

    /**
     * @param bool $hasNominationRight nomination right indicator
     * @return array array of all members with given nomination right
     */
    public function getMembersWithNominationRight(bool $hasNominationRight)
    {
        $nominationRanks = $this->getDatabase()
            ->table(RankMetadata::$tableName)
            ->where(RankMetadata::$hasNominationRight, $hasNominationRight)
            ->fetchAll();
        $nominationMembers = array();
        foreach ($nominationRanks as $activeRank) {
            $rankMembers = $activeRank->related(MemberMetadata::$tableName, MemberMetadata::$rankId);
            foreach ($rankMembers as $rankMember) {
                $nominationMembers[] = $rankMember;
            }
        }
        return $nominationMembers;
    }

}