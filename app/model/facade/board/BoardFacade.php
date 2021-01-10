<?php

declare(strict_types=1);


namespace App\model\facade\board;

use App\model\common\utils\MemberUtils;
use App\model\core\security\SecurityMetadata;
use App\model\core\security\SecurityResolver;
use App\model\dal\dao\BoardDAO;
use App\model\dal\dao\MemberDAO;
use App\model\dal\metadata\BoardMemberMetadata;
use App\model\dal\metadata\BoardMetadata;
use App\model\dal\metadata\BoardPositionMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\facade\common\CommonFacade;
use App\model\to\oto\board\BoardDetailOTO;
use App\model\to\oto\board\BoardEditFormOTO;
use App\model\to\oto\board\BoardForViewOTO;
use App\model\to\oto\board\BoardDetailBoardMemberOTO;
use DateTime;
use Exception;
use Nette\Security\User;

/**
 * Class BoardFacade
 *
 * Component handling board related stuff in service layer
 *
 * @package App\model\facade\board
 */
class BoardFacade extends CommonFacade
{
    private BoardDAO $boardDAO;
    private MemberDAO $memberDAO;

    private BoardTOFiller $boardTOFiller;

    /**
     * BoardFacade constructor.
     *
     * @param BoardDAO $boardDAO
     * @param MemberDAO $memberDAO
     * @param BoardTOFiller $boardTOFiller
     * @param User $user
     * @param SecurityResolver $securityResolver
     */
    public function __construct(BoardDAO $boardDAO, MemberDAO $memberDAO, BoardTOFiller $boardTOFiller, User $user, SecurityResolver $securityResolver)
    {
        parent::__construct($user, $securityResolver);
        $this->boardDAO = $boardDAO;
        $this->memberDAO = $memberDAO;
        $this->boardTOFiller = $boardTOFiller;
    }

    /**
     * @return int|null id of the current board
     */
    public function getCurrentBoardId(): ?int
    {
        $now = new DateTime();
        $boards = $this->boardDAO->getBoards(null, $now, $now, null);
        if (count($boards) != 1) {
            return null;
        }

        $boardEO = array_pop($boards);

        return $boardEO[BoardMetadata::$boardId];
    }

    /**
     * @param int $boardId board id
     * @return BoardDetailOTO|null transfer object representing a single board
     * @throws Exception
     */
    public function getBoardDetail(int $boardId): ?BoardDetailOTO
    {
        $this->checkPermission(SecurityMetadata::boardResource, SecurityMetadata::$viewAction);

        $boardEO = $this->boardDAO->getBoard($boardId);
        $boardNumber = $boardEO[BoardMetadata::$number];
        $previousBoardEO = $this->boardDAO->findBoardByNumber($boardNumber - 1);
        $previousBoardId = $previousBoardEO ? $previousBoardEO[BoardMetadata::$boardId] : null;
        $followingBoardEO = $this->boardDAO->findBoardByNumber($boardNumber + 1);
        $followingBoardId = $followingBoardEO ? $followingBoardEO[BoardMetadata::$boardId] : null;

        $boardMembers = array();
        foreach ($boardEO->related(BoardMemberMetadata::$tableName, BoardMemberMetadata::$boardId) as $boardMemberEO) {
            $boardMemberOTO = $this->boardTOFiller->fillBoardDetailBoardMember(new BoardDetailBoardMemberOTO(), $boardMemberEO);
            $boardMembers[] = $boardMemberOTO;
        }

        $createBoardPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::boardResource, SecurityMetadata::$createAction);
        $editBoardPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::boardResource, SecurityMetadata::$editAction);
        $deleteBoardPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::boardResource, SecurityMetadata::$deleteAction);

        $boardDetailOTO = $this->boardTOFiller->fillBoardDetail(new BoardDetailOTO(), $boardEO, $boardMembers, $previousBoardId, $followingBoardId, $createBoardPermissionLevel, $editBoardPermissionLevel, $deleteBoardPermissionLevel);
        return $boardDetailOTO;
    }

    /**
     * @return array array of basic infromation about all boards
     * @throws Exception
     */
    public function getBoardsForView(): array
    {
        $this->checkPermission(SecurityMetadata::boardResource, SecurityMetadata::$viewAction);

        $boards = $this->boardDAO->getBoards(null, null, null, null);

        $boardsForView = array();
        foreach ($boards as $boardEO) {
            $boardForView = $this->boardTOFiller->fillBoardForView(new BoardForViewOTO(), $boardEO);
            $boardsForView[] = $boardForView;
        }
        return $boardsForView;
    }

    /**
     * @return BoardEditFormOTO OTO containing info for the form for creating/editing board
     */
    public function getBoardEditForm(): BoardEditFormOTO
    {
        $memberOptions = array();
        $memberEOs = $this->memberDAO->getMembers();
        $memberOptions[null] = '-';
        foreach ($memberEOs as $memberEO) {
            $memberId = $memberEO[MemberMetadata::$memberId];
            $memberOptions[$memberId] = MemberUtils::resolveDisplayName($memberEO);
        }

        $boardPositions = array();
        $boardPositionEOs = $this->boardDAO->getBoardPositions();
        foreach ($boardPositionEOs as $boardPositionEO) {
            $boardPositions[$boardPositionEO[BoardPositionMetadata::$boardPositionId]] = $boardPositionEO[BoardPositionMetadata::$name];
        }

        $boardEditFormOTO = $this->boardTOFiller->fillBoardEditForm(new BoardEditFormOTO(), $boardPositions, $memberOptions);
        return $boardEditFormOTO;
    }

    //todo create OTO

    /**
     * @param int $boardId board id
     * @return array array with default values for a edit form
     */
    public function getBoardForForm(int $boardId): array
    {
        $boardEO = $this->boardDAO->getBoard($boardId);
        $boardMemberEOs = $boardEO->related(BoardMemberMetadata::$tableName, BoardMemberMetadata::$boardId);

        $boardArray = $boardEO->toArray();
        $boardMembers = array();
        foreach ($boardMemberEOs as $boardMemberEO) {
            $boardMembers[$boardMemberEO[BoardMemberMetadata::$boardPositionId]] = $boardMemberEO[BoardMemberMetadata::$memberId];
        }
        $boardArray["boardMembers"] = $boardMembers;

        return $boardArray;
    }

    // todo create ITO

    /**
     * @param array $boardArray board array to be added
     * @return int id of the added board
     * @throws Exception
     */
    public function addBoard(array $boardArray): int
    {
        $this->checkPermission(SecurityMetadata::boardResource, SecurityMetadata::$createAction);
        $boardMembers = $boardArray["boardMembers"];
        unset($boardArray["boardMembers"]);
        $boardEO = $this->boardDAO->insertBoard($boardArray);
        $boardId = $boardEO[BoardMetadata::$boardId];

        foreach ($boardMembers as $boardPositionId => $memberId) {
            if ($memberId) {
                $boardMemberArray = array();
                $boardMemberArray[BoardMemberMetadata::$memberId] = intval($memberId); // todo on presenter
                $boardMemberArray[BoardMemberMetadata::$boardId] = $boardId;
                $boardMemberArray[BoardMemberMetadata::$boardPositionId] = $boardPositionId;

                $this->boardDAO->insertBoardMember($boardMemberArray);
            }
        }

        return $boardId;
    }

    // todo create ITO

    /**
     * @param array $boardArray board array to be updated
     * @return int id of the updated board
     * @throws Exception
     */
    public function updateBoard(array $boardArray): int
    {
        $this->checkPermission(SecurityMetadata::boardResource, SecurityMetadata::$editAction);

        $boardMembers = $boardArray["boardMembers"];
        unset($boardArray["boardMembers"]);

        $boardId = $boardArray[BoardMetadata::$boardId];
        $boardEO = $this->boardDAO->getBoard($boardId);
        $boardEO->update($boardArray);

        foreach ($boardMembers as $boardPositionId => $memberId) {
            $boardMemberEO = $this->boardDAO->findBoardMember($boardId, $boardPositionId);
            if ($boardMemberEO) {
                if ($memberId) {
                    $boardMemberEO->update(array(BoardMemberMetadata::$memberId => $memberId));
                } else {
                    $boardMemberEO->delete();
                }
            } else if ($memberId) {
                $this->boardDAO->insertBoardMember(array(
                    BoardMemberMetadata::$boardId => $boardId,
                    BoardMemberMetadata::$boardPositionId => $boardPositionId,
                    BoardMemberMetadata::$memberId => $memberId
                ));
            }
        }

        return $boardId;
    }

    /**
     * @param int $boardId board id
     * @throws Exception
     */
    public function deleteBoard(int $boardId): void
    {
        $this->checkPermission(SecurityMetadata::boardResource, SecurityMetadata::$deleteAction);

        $this->boardDAO->deleteBoard($boardId);
    }

    /**
     * @param int $boardId board id
     * @param DateTime $startDate board mandate start date
     * @param DateTime $endDate board mandate end date
     * @return bool whether the mandate period can be set as the board's mandate period
     */
    public function isFeasibleBoardPeriod(int $boardId, DateTime $startDate, DateTime $endDate): bool
    {
        $collidingBoards = $this->boardDAO->getBoards(null, $endDate, $startDate, null);

        foreach ($collidingBoards as $collidingBoard) {
            if ($collidingBoard[BoardMetadata::$boardId] != $boardId) {
                return false;
            }
        }
        return true;

    }
}