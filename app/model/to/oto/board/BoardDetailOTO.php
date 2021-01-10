<?php

declare(strict_types=1);


namespace App\model\to\oto\board;

/**
 * Class BoardDetailOTO
 * @package App\model\to\oto\board
 */
class BoardDetailOTO extends BoardOTO
{
    private array $boardMembers;
    private ?int $previousBoardId = null;
    private ?int $followingBoardId = null;
    private string $createBoardPermissionLevel;
    private string $editBoardPermissionLevel;
    private string $deleteBoardPermissionLevel;

    /**
     * @return array
     */
    public function getBoardMembers(): array
    {
        return $this->boardMembers;
    }

    /**
     * @param array $boardMembers
     */
    public function setBoardMembers(array $boardMembers): void
    {
        $this->boardMembers = $boardMembers;
    }

    /**
     * @return int|null
     */
    public function getPreviousBoardId(): ?int
    {
        return $this->previousBoardId;
    }

    /**
     * @param int|null $previousBoardId
     */
    public function setPreviousBoardId(?int $previousBoardId): void
    {
        $this->previousBoardId = $previousBoardId;
    }

    /**
     * @return int|null
     */
    public function getFollowingBoardId(): ?int
    {
        return $this->followingBoardId;
    }

    /**
     * @param int|null $followingBoardId
     */
    public function setFollowingBoardId(?int $followingBoardId): void
    {
        $this->followingBoardId = $followingBoardId;
    }

    /**
     * @return string
     */
    public function getCreateBoardPermissionLevel(): string
    {
        return $this->createBoardPermissionLevel;
    }

    /**
     * @param string $createBoardPermissionLevel
     */
    public function setCreateBoardPermissionLevel(string $createBoardPermissionLevel): void
    {
        $this->createBoardPermissionLevel = $createBoardPermissionLevel;
    }

    /**
     * @return string
     */
    public function getEditBoardPermissionLevel(): string
    {
        return $this->editBoardPermissionLevel;
    }

    /**
     * @param string $editBoardPermissionLevel
     */
    public function setEditBoardPermissionLevel(string $editBoardPermissionLevel): void
    {
        $this->editBoardPermissionLevel = $editBoardPermissionLevel;
    }

    /**
     * @return string
     */
    public function getDeleteBoardPermissionLevel(): string
    {
        return $this->deleteBoardPermissionLevel;
    }

    /**
     * @param string $deleteBoardPermissionLevel
     */
    public function setDeleteBoardPermissionLevel(string $deleteBoardPermissionLevel): void
    {
        $this->deleteBoardPermissionLevel = $deleteBoardPermissionLevel;
    }

}