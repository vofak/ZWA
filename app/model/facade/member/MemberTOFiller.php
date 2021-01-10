<?php

declare(strict_types=1);


namespace App\model\facade\member;


use App\model\common\utils\MemberUtils;
use App\model\dal\metadata\BoardMemberMetadata;
use App\model\dal\metadata\BoardMetadata;
use App\model\dal\metadata\BoardPositionMetadata;
use App\model\dal\metadata\EventMetadata;
use App\model\dal\metadata\FacultyMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\dal\metadata\RankMetadata;
use App\model\dal\metadata\WorkingGroupMetadata;
use App\model\to\oto\member\MemberAngelOTO;
use App\model\to\oto\member\MemberBoardPositionOTO;
use App\model\to\oto\member\MemberBrowseViewOTO;
use App\model\to\oto\member\MemberCoreTeamPositionOTO;
use App\model\to\oto\member\MemberDetailOTO;
use App\model\to\oto\member\MemberEditFormOTO;
use App\model\to\oto\member\MemberForViewOTO;
use App\model\to\oto\member\MemberOTO;
use Nette\Database\Table\ActiveRow;

/**
 * Class MemberTOFiller
 *
 * Component filling member related transfer objects
 *
 * @package App\model\facade\member
 */
class MemberTOFiller
{
    private function fillMember(MemberOTO $memberOTO, ActiveRow $memberEO, ?MemberAngelOTO $angelOTO): MemberOTO
    {
        $rankEO = $memberEO->ref(RankMetadata::$tableName, MemberMetadata::$rankId);
        $wgEO = $memberEO->ref(WorkingGroupMetadata::$tableName, MemberMetadata::$workingGroupId);
        $facultyEO = $memberEO->ref(FacultyMetadata::$tableName, MemberMetadata::$facultyId);

        $memberOTO->setImageSrcPath(MemberUtils::resolveMemberImage($memberEO));
        $memberOTO->setMemberId($memberEO[MemberMetadata::$memberId]);
        $memberOTO->setName(MemberUtils::resolveDisplayName($memberEO));
        $memberOTO->setNickname($memberEO[MemberMetadata::$nickname]);
        $memberOTO->setEmail($memberEO[MemberMetadata::$email]);
        $memberOTO->setAngel($angelOTO);
        $memberOTO->setRankName($rankEO[RankMetadata::$name]);
        $memberOTO->setWg($wgEO ? $wgEO[WorkingGroupMetadata::$shortName] : null);
        $memberOTO->setFaculty($facultyEO ? $facultyEO[FacultyMetadata::$shortName] : null);
        $memberOTO->setBirthday($memberEO[MemberMetadata::$birthday]);
        $memberOTO->setJoinedDate($memberEO[MemberMetadata::$joinedDate]);
        $memberOTO->setShirtSize($memberEO[MemberMetadata::$shirtSize]);
        $memberOTO->setFacebook($memberEO[MemberMetadata::$facebook]);
        $memberOTO->setSkype($memberEO[MemberMetadata::$skype]);
        $memberOTO->setPhoneNumber($memberEO[MemberMetadata::$phoneNumber]);

        return $memberOTO;
    }

    public function fillMemberDetail(MemberDetailOTO $memberDetailOTO, ActiveRow $memberEO, ?MemberAngelOTO $angelOTO, array $coreTeamPositions, array $boardPositions, string $editPermissionLevel, string $deletePermissionLevel): MemberDetailOTO
    {
        $this->fillMember($memberDetailOTO, $memberEO, $angelOTO);

        $memberDetailOTO->setCoreTeamPositions($coreTeamPositions);
        $memberDetailOTO->setBoardPositions($boardPositions);
        $memberDetailOTO->setEditPermissionLevel($editPermissionLevel);
        $memberDetailOTO->setDeletePermissionLevel($deletePermissionLevel);

        return $memberDetailOTO;
    }

    public function fillMemberCoreTeamPosition(MemberCoreTeamPositionOTO $memberCoreTeamPositionOTO, ActiveRow $eventEO, ?int $coreTeamPositionId, string $coreTeamPositionName): MemberCoreTeamPositionOTO
    {
        $memberCoreTeamPositionOTO->setEventId($eventEO[EventMetadata::$eventId]);
        $memberCoreTeamPositionOTO->setEventName($eventEO[EventMetadata::$name]);
        $memberCoreTeamPositionOTO->setCoreTeamPositionId($coreTeamPositionId);
        $memberCoreTeamPositionOTO->setCoreTeamPositionName($coreTeamPositionName);
        $memberCoreTeamPositionOTO->setEventStartDate($eventEO[EventMetadata::$startDate]);
        $memberCoreTeamPositionOTO->setEventEndDate($eventEO[EventMetadata::$endDate]);

        return $memberCoreTeamPositionOTO;
    }

    public function fillMemberBoardPositionOTO(MemberBoardPositionOTO $memberBoardPositionOTO, ActiveRow $boardMemberEO): MemberBoardPositionOTO
    {
        $boardEO = $boardMemberEO->ref(BoardMetadata::$tableName, BoardMemberMetadata::$boardId);
        $boardPositionEO = $boardMemberEO->ref(BoardPositionMetadata::$tableName, BoardMemberMetadata::$boardPositionId);

        $memberBoardPositionOTO->setBoardId($boardEO[BoardMetadata::$boardId]);
        $memberBoardPositionOTO->setBoardName($boardEO[BoardMetadata::$name]);
        $memberBoardPositionOTO->setBoardPositionId($boardPositionEO[BoardPositionMetadata::$boardPositionId]);
        $memberBoardPositionOTO->setBoardPositionName($boardPositionEO[BoardPositionMetadata::$name]);
        $startDate = $boardMemberEO[BoardMemberMetadata::$startDate] ? $boardMemberEO[BoardMemberMetadata::$startDate] : $boardEO[BoardMetadata::$startDate];
        $memberBoardPositionOTO->setStartDate($startDate);
        $endDate = $boardMemberEO[BoardMemberMetadata::$endDate] ? $boardMemberEO[BoardMemberMetadata::$endDate] : $boardEO[BoardMetadata::$endDate];
        $memberBoardPositionOTO->setEndDate($endDate);

        return $memberBoardPositionOTO;
    }

    public function fillMemberAngel(MemberAngelOTO $angelOTO, ActiveRow $angelEO): MemberAngelOTO
    {
        $angelOTO->setAngelId($angelEO[MemberMetadata::$memberId]);
        $angelOTO->setName(MemberUtils::resolveDisplayName($angelEO));
        $angelOTO->setNickname($angelEO[MemberMetadata::$nickname]);

        return $angelOTO;
    }

    public function fillMemberBrowseView(MemberBrowseViewOTO $memberBrowseViewOTO, array $memberForViewOTOs, string $createMemberPermissionLevel): MemberBrowseViewOTO
    {
        $memberBrowseViewOTO->setMemberForViewOTOs($memberForViewOTOs);
        $memberBrowseViewOTO->setCreateMemberPermissionLevel($createMemberPermissionLevel);

        return $memberBrowseViewOTO;
    }

    public function fillMemberForView(MemberForViewOTO $memberForViewOTO, ActiveRow $memberEO, ?MemberAngelOTO $angelOTO): MemberForViewOTO
    {
        $this->fillMember($memberForViewOTO, $memberEO, $angelOTO);

        $rankEO = $memberEO->ref(RankMetadata::$tableName, MemberMetadata::$rankId);

        $memberForViewOTO->setGender($memberEO[MemberMetadata::$gender]);
        $memberForViewOTO->setActive(boolval($rankEO[RankMetadata::$isActive]));

        return $memberForViewOTO;
    }

    public function fillMemberEditForm(MemberEditFormOTO $memberEditFormOTO, array $angelOptions, array $facultyOptions, array $genderOptions, array $wgOptions, array $rankOptions, array $roleOptions, array $languageOptions, string $editSensitivePermissionLevel): MemberEditFormOTO
    {
        $memberEditFormOTO->setAngelOptions($angelOptions);
        $memberEditFormOTO->setFacultyOptions($facultyOptions);
        $memberEditFormOTO->setGenderOptions($genderOptions);
        $memberEditFormOTO->setRankOptions($rankOptions);
        $memberEditFormOTO->setWgOptions($wgOptions);
        $memberEditFormOTO->setRoleOptions($roleOptions);
        $memberEditFormOTO->setLanguageOptions($languageOptions);
        $memberEditFormOTO->setEditSensitivePermissionLevel($editSensitivePermissionLevel);

        return $memberEditFormOTO;
    }
}