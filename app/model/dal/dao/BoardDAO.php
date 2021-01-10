<?php

declare(strict_types=1);


namespace App\model\dal\dao;

use App\model\dal\dao\common\CommonDAO;
use App\model\dal\metadata\BoardMemberMetadata;
use App\model\dal\metadata\BoardMetadata;
use App\model\dal\metadata\BoardPositionMetadata;
use DateTime;
use Nette\Database\Table\ActiveRow;

/**
 * Class BoardDAO
 *
 * DAO working with entities concerning the board
 *
 * @package App\model\dal\dao
 */
class BoardDAO extends CommonDAO
{
    // BOARD

    /**
     * @param int $boardId board id
     * @return ActiveRow board EO
     */
    public function getBoard(int $boardId): ActiveRow
    {
        return $this->getDatabase()
            ->table(BoardMetadata::$tableName)
            ->get($boardId);
    }

    /**
     * @param int $boardNumber number of the board
     * @return ActiveRow|null board or null
     */
    public function findBoardByNumber(int $boardNumber): ?ActiveRow
    {
        return $this->getDatabase()
            ->table(BoardMetadata::$tableName)
            ->where(BoardMetadata::$number, $boardNumber)
            ->fetch();
    }

    /**
     * Inserts the board and returns the EO
     *
     * @param array $boardArray board array
     * @return ActiveRow board entity
     */
    public function insertBoard(array $boardArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(BoardMetadata::$tableName)
            ->insert($boardArray);
    }

    /**
     * Deletes the board and all the board member entities
     *
     * @param int $boardId board id
     */
    public function deleteBoard(int $boardId): void
    {
        $this->getDatabase()
            ->table(BoardMemberMetadata::$tableName)
            ->where(BoardMemberMetadata::$boardId, $boardId)
            ->delete();
        $this->getDatabase()
            ->table(BoardMetadata::$tableName)
            ->get($boardId)
            ->delete();
    }

    /**
     * @param DateTime|null $startDateFrom start date lowest value
     * @param DateTime|null $startDateUntil start date highest value
     * @param DateTime|null $endDateFrom end date lowest value
     * @param DateTime|null $endDateUntil end date highest value
     * @return array array of boards
     */
    public function getBoards(?DateTime $startDateFrom, ?DateTime $startDateUntil, ?DateTime $endDateFrom, ?DateTime $endDateUntil): array
    {
        $query = $this->getDatabase()
            ->table(BoardMetadata::$tableName);

        if ($startDateFrom) {
            $query->where(BoardMetadata::$startDate . " > ?", $startDateFrom);
        }
        if ($startDateUntil) {
            $query->where(BoardMetadata::$startDate . " < ?", $startDateUntil);
        }
        if ($endDateFrom) {
            $query->where(BoardMetadata::$endDate . " > ?", $endDateFrom);
        }
        if ($endDateUntil) {
            $query->where(BoardMetadata::$endDate . " < ?", $endDateUntil);
        }

        return $query->fetchAll();
    }

    // BOARD POSITION

    /**
     * @return array array of all existing board positions
     */
    public function getBoardPositions(): array
    {
        return $this->getDatabase()
            ->table(BoardPositionMetadata::$tableName)
            ->fetchAll();
    }

    // BOARD MEMBER

    /**
     * @param int $boardId board id
     * @param int $boardPositionId board position id
     * @return ActiveRow|null board member in a given board at a given position
     */
    public function findBoardMember(int $boardId, int $boardPositionId): ?ActiveRow
    {
        $query = $this->getDatabase()
            ->table(BoardMemberMetadata::$tableName)
            ->where(BoardMemberMetadata::$boardId, $boardId)
            ->where(BoardMemberMetadata::$boardPositionId, $boardPositionId);

        return $this->findUnique($query);
    }

    /**
     * @param array $boardMemberArray board member array
     * @return ActiveRow board member EO
     */
    public function insertBoardMember(array $boardMemberArray): ActiveRow
    {
        return $this->getDatabase()
            ->table(BoardMemberMetadata::$tableName)
            ->insert($boardMemberArray);
    }

}