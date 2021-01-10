<?php

declare(strict_types=1);


namespace App\model\dal\dao;


use App\model\dal\dao\common\CommonDAO;
use App\model\dal\metadata\ElectionBoardPositionMetadata;
use App\model\dal\metadata\ElectionMetadata;
use App\model\dal\metadata\NominationMetadata;
use Nette\Database\Table\ActiveRow;

/**
 * Class ElectionDAO
 *
 * DAO working with entities concerning the election
 *
 * @package App\model\dal\dao
 */
class ElectionDAO extends CommonDAO
{

    // ELECTION

    /**
     * @param int $electionId election id
     * @return ActiveRow election EO
     */
    public function getElection(int $electionId): ActiveRow
    {
        return $this->getDatabase()
            ->table(ElectionMetadata::$tableName)
            ->get($electionId);
    }

    /**
     * @param array $electionArray election array
     * @return ActiveRow inserted election EO
     */
    public function insertElection(array $electionArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(ElectionMetadata::$tableName)
            ->insert($electionArray);
    }

    /**
     * Deletes election from the database
     *
     * @param int $electionId election id
     */
    public function deleteElection(int $electionId): void
    {
        $this->getDatabase()
            ->table(NominationMetadata::$tableName)
            ->where(NominationMetadata::$electionId, $electionId)
            ->delete();
        $this->getDatabase()
            ->table(ElectionBoardPositionMetadata::$tableName)
            ->where(ElectionBoardPositionMetadata::$electionId, $electionId)
            ->delete();
        $this->getDatabase()
            ->table(ElectionMetadata::$tableName)
            ->get($electionId)
            ->delete();
    }

    /**
     * @return array array of all existing elections
     */
    public function getElections(): array
    {
        return $this->getDatabase()
            ->table(ElectionMetadata::$tableName)
            ->order(ElectionMetadata::$startDate . " DESC")
            ->fetchAll();
    }

    // ELECTION BOARD POSITION

    /**
     * @param array $electionBoardPositionArray election board position array
     * @return ActiveRow inserted election board position EO
     */
    public function insertElectionBoardPosition(array $electionBoardPositionArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(ElectionBoardPositionMetadata::$tableName)
            ->insert($electionBoardPositionArray);
    }

    // NOMINATION

    /**
     * @param array $nominationArray nomination array
     * @return ActiveRow inserted nomination EO
     */
    public function insertNomination(array $nominationArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(NominationMetadata::$tableName)
            ->insert($nominationArray);
    }

    /**
     * @param int $electionId election id
     * @param int $nomineeId nominee id
     * @return array for member in election returns array boardPosition -> number of nominations
     */
    public function getNominationCounts(int $electionId, int $nomineeId): array
    {
        return $this->getDatabase()
            ->table(NominationMetadata::$tableName)
            ->select(NominationMetadata::$boardPositionId . ", count(" . NominationMetadata::$nominationId . ")")
            ->where(NominationMetadata::$electionId, $electionId)
            ->where(NominationMetadata::$nomineeId, $nomineeId)
            ->group(NominationMetadata::$boardPositionId)
            ->fetchAll();
    }

    /**
     * @param int|null $electionId election id
     * @param int|null $proposerId proposer id
     * @param int|null $nomineeId nominee id
     * @return array array of all nominations
     */
    public function getNominations(?int $electionId, ?int $proposerId, ?int $nomineeId): array
    {
        $query = $this->getDatabase()
            ->table(NominationMetadata::$tableName);

        if ($electionId) {
            $query->where(NominationMetadata::$electionId, $electionId);
        }

        if ($proposerId) {
            $query->where(NominationMetadata::$proposerId, $proposerId);
        }

        if ($nomineeId) {
            $query->where(NominationMetadata::$nomineeId, $nomineeId);
        }
        return $query->fetchAll();
    }

}