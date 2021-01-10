<?php

declare(strict_types=1);


namespace App\model\facade\board;


use App\model\common\utils\MemberUtils;
use App\model\dal\metadata\BoardMemberMetadata;
use App\model\dal\metadata\BoardMetadata;
use App\model\dal\metadata\BoardPositionMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\to\oto\board\BoardDetailOTO;
use App\model\to\oto\board\BoardEditFormOTO;
use App\model\to\oto\board\BoardForViewOTO;
use App\model\to\oto\board\BoardDetailBoardMemberOTO;
use App\model\to\oto\board\BoardOTO;
use Nette\Database\Table\ActiveRow;

/**
 * Class BoardTOFiller
 *
 * Component filling board related transfer objects
 *
 * @package App\model\facade\board
 */
class BoardTOFiller
{
    public function fillBoard(BoardOTO $boardOTO, ActiveRow $boardEO): BoardOTO
    {
        $boardOTO->setBoardId($boardEO[BoardMetadata::$boardId]);
        $boardOTO->setBoardNumber($boardEO[BoardMetadata::$number]);
        $boardOTO->setBoardName($boardEO[BoardMetadata::$name]);
        $boardOTO->setStartDate($boardEO[BoardMetadata::$startDate]);
        $boardOTO->setEndDate($boardEO[BoardMetadata::$endDate]);

        return $boardOTO;
    }

    public function fillBoardDetail(BoardDetailOTO $boardDetailOTO, ActiveRow $boardEO, array $boardMembers, ?int $previousBoardId, ?int $followingBoardId, string $createBoardPermissionLevel, string $editBoardPermissionLevel, string $deleteBoardPermissionLevel): BoardDetailOTO
    {
        $this->fillBoard($boardDetailOTO, $boardEO);

        $boardDetailOTO->setBoardMembers($boardMembers);
        $boardDetailOTO->setPreviousBoardId($previousBoardId);
        $boardDetailOTO->setFollowingBoardId($followingBoardId);
        $boardDetailOTO->setCreateBoardPermissionLevel($createBoardPermissionLevel);
        $boardDetailOTO->setEditBoardPermissionLevel($editBoardPermissionLevel);
        $boardDetailOTO->setDeleteBoardPermissionLevel($deleteBoardPermissionLevel);

        return $boardDetailOTO;
    }

    public function fillBoardDetailBoardMember(BoardDetailBoardMemberOTO $boardDetailBoardMemberOTO, ActiveRow $boardMemberEO): BoardDetailBoardMemberOTO
    {
        $memberEO = $boardMemberEO->ref(MemberMetadata::$tableName, BoardMemberMetadata::$memberId);
        $boardPositionEO = $boardMemberEO->ref(BoardPositionMetadata::$tableName, BoardMemberMetadata::$boardPositionId);

        $boardDetailBoardMemberOTO->setMemberId($memberEO[MemberMetadata::$memberId]);
        $boardDetailBoardMemberOTO->setName(MemberUtils::resolveDisplayName($memberEO));
        $boardDetailBoardMemberOTO->setStartDate($boardMemberEO[BoardMemberMetadata::$startDate]);
        $boardDetailBoardMemberOTO->setEndDate($boardMemberEO[BoardMemberMetadata::$endDate]);
        $boardDetailBoardMemberOTO->setBoardPositionName($boardPositionEO[BoardPositionMetadata::$name]);
        $boardDetailBoardMemberOTO->setImageSrcPath(MemberUtils::resolveMemberImage($memberEO));

        return $boardDetailBoardMemberOTO;
    }

    public function fillBoardForView(BoardForViewOTO $boardForView, ActiveRow $boardEO): BoardForViewOTO
    {
        $this->fillBoard($boardForView, $boardEO);

        return $boardForView;
    }

    public function fillBoardEditForm(BoardEditFormOTO $boardEditFormOTO, array $boardPositions, array $memberOptions)
    {
        $boardEditFormOTO->setBoardPositions($boardPositions);
        $boardEditFormOTO->setMemberOptions($memberOptions);

        return $boardEditFormOTO;
    }
}