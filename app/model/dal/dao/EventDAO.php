<?php

declare(strict_types=1);


namespace App\model\dal\dao;


use App\model\dal\dao\common\CommonDAO;
use App\model\dal\metadata\CoreTeamPositionMetadata;
use App\model\dal\metadata\EventMetadata;
use Nette\Database\Table\ActiveRow;

/**
 * Class EventDAO
 *
 * DAO working with entities concerning the event
 *
 * @package App\model\dal\dao
 */
class EventDAO extends CommonDAO
{

    // EVENT

    /**
     * @param int $eventId event id
     * @return ActiveRow event EO
     */
    public function getEvent(int $eventId): ActiveRow
    {
        return $this->getDatabase()
            ->table(EventMetadata::$tableName)
            ->get($eventId);
    }

    /**
     * @param array $eventArray event array
     * @return ActiveRow inserted event EO
     */
    public function insertEvent(array $eventArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(EventMetadata::$tableName)
            ->insert($eventArray);
    }

    /**
     * Deletes the event and all its core team positions
     *
     * @param int $eventId event id
     */
    public function deleteEvent(int $eventId): void
    {
        $this->getDatabase()
            ->table(CoreTeamPositionMetadata::$tableName)
            ->where(CoreTeamPositionMetadata::$eventId, $eventId)
            ->delete();
        $this->getDatabase()
            ->table(EventMetadata::$tableName)
            ->get($eventId)
            ->delete();
    }

    /**
     * @param int $memberId member id
     * @return array array of all events where the member was main organiser
     */
    public function getEventsForMember(int $memberId): array
    {
        return $this->getDatabase()
            ->table(EventMetadata::$tableName)
            ->where(EventMetadata::$mainOrganiserId, $memberId)
            ->fetchAll();
    }

    /**
     * @param int|null $offset offset
     * @param int|null $limit limit
     * @param int|null $search search string
     * @return array array of all existing events
     */
    public function getEvents($offset, $limit, $search): array
    {
        $query = $this->getDatabase()
            ->table(EventMetadata::$tableName)
            ->order(EventMetadata::$startDate . " DESC");

        if (!is_null($limit) && !is_null($limit)) {
            $query = $query->limit($limit, $offset);
        }

        if (!is_null($search)) {
            $query = $query->where(EventMetadata::$name . " LIKE ?", "%" . $search . "%");
        }

        return $query->fetchAll();
    }

    // CORE TEAM POSITION

    /**
     * @param int $coreTeamPositionId core team position id
     * @return ActiveRow core team position EO
     */
    public function getCoreTeamPosition(int $coreTeamPositionId): ActiveRow
    {
        return $this->getDatabase()
            ->table(CoreTeamPositionMetadata::$tableName)
            ->get($coreTeamPositionId);
    }

    /**
     * @param int $coreTeamPositionId core team position id
     */
    public function deleteCoreTeamPosition(int $coreTeamPositionId): void
    {
        $this->getDatabase()
            ->table(CoreTeamPositionMetadata::$tableName)
            ->get($coreTeamPositionId)
            ->delete();
    }

    /**
     * @param int $memberId member id
     * @return array array of all core team positions of the member
     */
    public function getCoreTeamPositionsForMember(int $memberId): array
    {
        return $this->getDatabase()
            ->table(CoreTeamPositionMetadata::$tableName)
            ->where(CoreTeamPositionMetadata::$memberId, $memberId)
            ->fetchAll();
    }

    /**
     * @param int $eventId event id
     * @return array array of all core teams positions in the event
     */
    public function getCoreTeamPositionsForEvent(int $eventId): array
    {
        return $this->getDatabase()
            ->table(CoreTeamPositionMetadata::$tableName)
            ->where(CoreTeamPositionMetadata::$eventId, $eventId)
            ->fetchAll();
    }

    /**
     * @param array $coreTeamPositionArray core team position array
     * @return ActiveRow inserted core team position EO
     */
    public function insertCoreTeamPosition(array $coreTeamPositionArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(CoreTeamPositionMetadata::$tableName)
            ->insert($coreTeamPositionArray);
    }

}