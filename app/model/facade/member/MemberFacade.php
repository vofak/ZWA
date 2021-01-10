<?php

declare(strict_types=1);


namespace App\model\facade\member;


use App\model\common\Gender;
use App\model\common\UserRole;
use App\model\common\utils\MemberUtils;
use App\model\core\security\resource\MemberResource;
use App\model\core\security\SecurityMetadata;
use App\model\core\security\SecurityResolver;
use App\model\dal\dao\EventDAO;
use App\model\dal\dao\MemberDAO;
use App\model\dal\dao\SystemDAO;
use App\model\dal\metadata\BoardMemberMetadata;
use App\model\dal\metadata\CoreTeamPositionMetadata;
use App\model\dal\metadata\EventMetadata;
use App\model\dal\metadata\FacultyMetadata;
use App\model\dal\metadata\LanguageMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\dal\metadata\RankMetadata;
use App\model\dal\metadata\WorkingGroupMetadata;
use App\model\facade\common\CommonFacade;
use App\model\facade\stats\StatsTOFiller;
use App\model\to\oto\member\MemberAngelOTO;
use App\model\to\oto\member\MemberBoardPositionOTO;
use App\model\to\oto\member\MemberBrowseViewOTO;
use App\model\to\oto\member\MemberCoreTeamPositionOTO;
use App\model\to\oto\member\MemberDetailOTO;
use App\model\to\oto\member\MemberEditFormOTO;
use App\model\to\oto\member\MemberForViewOTO;
use App\model\to\oto\stats\StatsDataOTO;
use App\model\to\oto\stats\StatsDickBoobsRatioOTO;
use App\model\to\oto\stats\StatsGenderedDataOTO;
use Exception;
use Nette\Security\User;

/**
 * Class MemberFacade
 *
 * Component handling member related stuff in service layer
 *
 * @package App\model\facade\member
 */
class MemberFacade extends CommonFacade
{
    private MemberDAO $memberDAO;
    private EventDAO $eventDAO;
    private SystemDAO $systemDAO;

    private MemberTOFiller $memberTOFiller;
    private StatsTOFiller $statsTOFiller;

    /**
     * MemberFacade constructor.
     *
     * @param MemberDAO $memberDAO
     * @param EventDAO $eventDAO
     * @param SystemDAO $systemDAO
     * @param MemberTOFiller $memberTOFiller
     * @param User $user
     * @param SecurityResolver $securityResolver
     */
    public function __construct(MemberDAO $memberDAO, EventDAO $eventDAO, SystemDAO $systemDAO, MemberTOFiller $memberTOFiller, StatsTOFiller $statsTOFiller, User $user, SecurityResolver $securityResolver)
    {
        parent::__construct($user, $securityResolver);
        $this->memberDAO = $memberDAO;
        $this->eventDAO = $eventDAO;
        $this->systemDAO = $systemDAO;
        $this->memberTOFiller = $memberTOFiller;
        $this->statsTOFiller = $statsTOFiller;
    }

    /**
     * @param int $memberId member id
     * @return MemberDetailOTO OTO containing info about a single member
     * @throws Exception
     */
    public function getMemberDetail(int $memberId): MemberDetailOTO
    {
        $memberEO = $this->memberDAO->getMember($memberId);
        $memberResource = new MemberResource($memberEO);
        $this->checkPermission($memberResource, SecurityMetadata::$viewAction);

        $coreTeamPositionEOs = $memberEO->related(CoreTeamPositionMetadata::$tableName, CoreTeamPositionMetadata::$memberId);
        $moEventEOs = $memberEO->related(EventMetadata::$tableName, EventMetadata::$mainOrganiserId);
        $boardMemberEOs = $memberEO->related(BoardMemberMetadata::$tableName, BoardMemberMetadata::$memberId);

        $coreTeamPositions = array();
        foreach ($coreTeamPositionEOs as $coreTeamPositionEO) {
            $eventEO = $coreTeamPositionEO->ref(EventMetadata::$tableName, CoreTeamPositionMetadata::$eventId);
            $coreTeamPositionId = $coreTeamPositionEO[CoreTeamPositionMetadata::$eventId];
            $coreTeamPositionName = $coreTeamPositionEO[CoreTeamPositionMetadata::$name];
            $coreTeamPositionOTO = $this->memberTOFiller->fillMemberCoreTeamPosition(new MemberCoreTeamPositionOTO(), $eventEO, $coreTeamPositionId, $coreTeamPositionName);
            $coreTeamPositions[] = $coreTeamPositionOTO;
        }

        foreach ($moEventEOs as $moEventEO) {
            $coreTeamPositionOTO = $this->memberTOFiller->fillMemberCoreTeamPosition(new MemberCoreTeamPositionOTO(), $moEventEO, null, "Main Organiser");
            $coreTeamPositions[] = $coreTeamPositionOTO;
        }

        $boardPositions = array();
        foreach ($boardMemberEOs as $boardMemberEO) {
            $boardPositionOTO = $this->memberTOFiller->fillMemberBoardPositionOTO(new MemberBoardPositionOTO(), $boardMemberEO);
            $boardPositions[] = $boardPositionOTO;
        }

        $angelOTO = null;
        if ($memberEO[MemberMetadata::$angelId]) {
            $angelEO = $memberEO->ref(MemberMetadata::$tableName, MemberMetadata::$angelId);
            $angelOTO = $this->memberTOFiller->fillMemberAngel(new MemberAngelOTO(), $angelEO);
        }

        $editPermissionLevel = $this->resolvePermissionLevel($memberResource, SecurityMetadata::$editAction);
        $deletePermissionLevel = $this->resolvePermissionLevel($memberResource, SecurityMetadata::$deleteAction);

        $memberOTO = $this->memberTOFiller->fillMemberDetail(new MemberDetailOTO(), $memberEO, $angelOTO, $coreTeamPositions, $boardPositions, $editPermissionLevel, $deletePermissionLevel);
        return $memberOTO;
    }

    /**
     * @return MemberBrowseViewOTO OTO conatining info about all the members
     * @throws Exception
     */
    public function getMemberBrowseView(): MemberBrowseViewOTO
    {
        $this->checkPermission(SecurityMetadata::memberResource, SecurityMetadata::$viewAction);

        $memberEOs = $this->memberDAO->getMembers();

        $memberForViewOTOs = array();
        foreach ($memberEOs as $memberEO) {
            $angelOTO = null;
            if ($memberEO->id_angel) {
                $angelEO = $this->memberDAO->getMember($memberEO->id_angel);
                $angelOTO = $this->memberTOFiller->fillMemberAngel(new MemberAngelOTO(), $angelEO);
            }
            $memberForViewOTO = $this->memberTOFiller->fillMemberForView(new MemberForViewOTO(), $memberEO, $angelOTO);
            $memberForViewOTOs[] = $memberForViewOTO;
        }

        $createMemberPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::memberResource, SecurityMetadata::$createAction);

        $memberBrowseViewOTO = $this->memberTOFiller->fillMemberBrowseView(new MemberBrowseViewOTO(), $memberForViewOTOs, $createMemberPermissionLevel);
        return $memberBrowseViewOTO;
    }

    /**
     * @return MemberEditFormOTO info for the member create/edit form
     */
    public function getMemberEditForm(): MemberEditFormOTO
    {
        $genderOptions = array(
            Gender::male => 'muž',
            Gender::female => 'žena',
        );

        $wgOptions = array();
        $wgEOs = $this->systemDAO->getWorkingGroups();
        $wgOptions[null] = '-';
        foreach ($wgEOs as $wgEO) {
            $wgId = $wgEO[WorkingGroupMetadata::$workingGroupId];
            $wgOptions[$wgId] = $wgEO[WorkingGroupMetadata::$shortName];
        }

        $roleOptions = array(
            UserRole::member => 'member',
            UserRole::admin => 'admin'
        );

        $facultyOptions = array();
        $facultyEOs = $this->systemDAO->getFaculties();
        $facultyOptions[null] = '-';
        foreach ($facultyEOs as $facultyEO) {
            $facultyId = $facultyEO[FacultyMetadata::$facultyId];
            $facultyOptions[$facultyId] = $facultyEO[FacultyMetadata::$shortName];
        }

        $rankOptions = array();
        $rankEOs = $this->systemDAO->getRanks();
        foreach ($rankEOs as $rankEO) {
            $rankOptions[$rankEO[RankMetadata::$rankId]] = $rankEO[RankMetadata::$name];
        }

        $angelOptions = array();
        $angelEOs = $this->memberDAO->getMembers();
        $angelOptions[null] = '-';
        foreach ($angelEOs as $angelEO) {
            $angelId = $angelEO[MemberMetadata::$memberId];
            $angelOptions[$angelId] = MemberUtils::resolveDisplayName($angelEO);
        }

        $languageOptions = array();
        $languageEOs = $this->systemDAO->getLanguages();
        foreach ($languageEOs as $languageEO) {
            $languageOptions[$languageEO[LanguageMetadata::$languageId]] = $languageEO[LanguageMetadata::$iso2];
        }


        $editSensitivePermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::memberResource, SecurityMetadata::$editSensitiveAction);

        $memberEditFormOTO = $this->memberTOFiller->fillMemberEditForm(new MemberEditFormOTO(), $angelOptions, $facultyOptions, $genderOptions, $wgOptions, $rankOptions, $roleOptions, $languageOptions, $editSensitivePermissionLevel);
        return $memberEditFormOTO;
    }

    /**
     * @param int $memberId member id
     * @return array default values for member edit form
     * @throws Exception
     */
    public function getMemberForForm(int $memberId): array
    {
        $this->checkPermission(SecurityMetadata::memberResource, SecurityMetadata::$viewAction);

        $memberEO = $this->memberDAO->getMember($memberId);
        return $memberEO->toArray();
    }

    /**
     * @param array $memberArray member array to be updated
     * @return int id of the updated member
     * @throws Exception
     */
    public function updateMember(array $memberArray): int
    {
        $memberResource = new MemberResource($memberArray);
        if (!$this->isAllowed($memberResource, SecurityMetadata::$editSensitiveAction)) {
            unset($memberArray[MemberMetadata::$rankId]);
            unset($memberArray[MemberMetadata::$angelId]);
            unset($memberArray[MemberMetadata::$workingGroupId]);
            unset($memberArray[MemberMetadata::$role]);
        }
        $memberId = $memberArray[MemberMetadata::$memberId];
        $memberEO = $this->memberDAO->getMember($memberId);
        $memberResource = new MemberResource($memberEO);
        $this->checkPermission($memberResource, SecurityMetadata::$editAction);

        $memberEO->update($memberArray);
        return $memberId;
    }

    /**
     * @param array $memberArray member array to be added
     * @return int id of the added member
     * @throws Exception
     */
    public function addMember(array $memberArray): int
    {
        $this->checkPermission(SecurityMetadata::memberResource, SecurityMetadata::$createAction);

        $memberEO = $this->memberDAO->insertMember($memberArray);
        return $memberEO[MemberMetadata::$memberId];
    }

    /**
     * @param int $memberId member id
     * @throws Exception
     */
    public function deleteMember(int $memberId): void
    {
        $this->checkPermission(SecurityMetadata::memberResource, SecurityMetadata::$deleteAction);

        $this->memberDAO->deleteMember($memberId);
    }

    /**
     * @param int $memberId member id
     * @param string $email suggested email
     * @return bool whether the email can be set as the email of the member
     */
    public function isFeasibleEmail(int $memberId, string $email): bool
    {
        $memberEO = $this->memberDAO->findMemberByEmail($email);

        return is_null($memberEO) || $memberId == $memberEO[MemberMetadata::$memberId];
    }

    // STATS

    /**
     * @return StatsDataOTO OTO containing statistics data about the LBG
     */
    public function getActiveMembersRankData(): StatsDataOTO
    {
        $rankEOs = $this->systemDAO->getRanks(true);

        $rankNames = array();
        $memberRankData = array();
        $rankIndexes = array();
        $i = 0;
        foreach ($rankEOs as $rankEO) {
            $rankIndexes[$rankEO[RankMetadata::$rankId]] = $i++;
            $rankNames[] = $rankEO[RankMetadata::$name];
            $memberRankData[] = 0;
        }

        $activeMemberEOs = $this->memberDAO->getMembersWithActivity(true);
        foreach ($activeMemberEOs as $activeMemberEO) {
            $rankEO = $activeMemberEO->ref(RankMetadata::$tableName, MemberMetadata::$rankId);

            $rankIndex = $rankIndexes[$rankEO[RankMetadata::$rankId]];
            $memberRankData[$rankIndex] = $memberRankData[$rankIndex] + 1;
        }

        $memberRankDataOTO = $this->statsTOFiller->fillStatsData(new StatsDataOTO(), $rankNames, $memberRankData);
        return $memberRankDataOTO;
    }

    /**
     * @return StatsGenderedDataOTO OTO containing statistics data about the LBG's active members' faculties divided into male and female
     */
    public function getActiveMembersFacultyData(): StatsGenderedDataOTO
    {
        $facultyEOs = $this->systemDAO->getFaculties();

        $facultyNames = array();
        $maleMemberFacultyData = array();
        $femaleMemberFacultyData = array();
        $facultyIndexes = array();
        $i = 0;
        foreach ($facultyEOs as $facultyEO) {
            $facultyIndexes[$facultyEO[FacultyMetadata::$facultyId]] = $i++;
            $facultyNames[] = $facultyEO[FacultyMetadata::$shortName];
            $maleMemberFacultyData[] = 0;
            $femaleMemberFacultyData[] = 0;
        }
        $facultyNames[] = "unspecified";
        $maleMemberFacultyData[] = 0;
        $femaleMemberFacultyData[] = 0;

        $activeMemberEOs = $this->memberDAO->getMembersWithActivity(true);
        foreach ($activeMemberEOs as $activeMemberEO) {
            $facultyEO = $activeMemberEO->ref(FacultyMetadata::$tableName, MemberMetadata::$facultyId);
            $facultyIndex = $facultyEO ? $facultyIndexes[$facultyEO[FacultyMetadata::$facultyId]] : $i;
            if ($activeMemberEO[MemberMetadata::$gender] == Gender::male) {
                $maleMemberFacultyData[$facultyIndex] = $maleMemberFacultyData[$facultyIndex] + 1;
            } else if ($activeMemberEO[MemberMetadata::$gender] == Gender::female) {
                $femaleMemberFacultyData[$facultyIndex] = $femaleMemberFacultyData[$facultyIndex] + 1;
            }

        }

        $memberFacultyDataOTO = $this->statsTOFiller->fillStatsGenderedData(new StatsGenderedDataOTO(), $facultyNames, $maleMemberFacultyData, $femaleMemberFacultyData);
        return $memberFacultyDataOTO;
    }

    /**
     * @return StatsDickBoobsRatioOTO OTO with a ratio of male vs female active members
     */
    public function getActiveMembersGenderData(): StatsDickBoobsRatioOTO
    {
        $activeMemberEOs = $this->memberDAO->getMembersWithActivity(true);
        $dickCount = 0;
        $boobsCount = 0;
        foreach ($activeMemberEOs as $activeMemberEO) {
            if ($activeMemberEO[MemberMetadata::$gender] == Gender::male) {
                $dickCount++;
            }
            else {
                $boobsCount++;
            }
        }
        $dickRatio = intval($dickCount * 100 / count($activeMemberEOs));
        $boobsRatio = intval($boobsCount * 100 / count($activeMemberEOs));

        $genderData = $this->statsTOFiller->fillStatsDickBoobsRatio(new StatsDickBoobsRatioOTO(), $dickRatio, $boobsRatio);
        return $genderData;
    }

    /**
     * @return StatsDataOTO OTO containing statistics data about active members' working groups
     */
    public function getActiveMembersWorkingGroupData(): StatsDataOTO
    {
        $wgEOs = $this->systemDAO->getWorkingGroups();

        $wgNames = array();
        $memberWgData = array();
        $wgIndexes = array();
        $i = 0;
        foreach ($wgEOs as $wgEO) {
            $wgIndexes[$wgEO[WorkingGroupMetadata::$workingGroupId]] = $i++;
            $wgNames[] = $wgEO[WorkingGroupMetadata::$shortName];
            $memberWgData[] = 0;
        }
        $wgNames[] = "unspecified";
        $memberWgData[] = 0;

        $activeMemberEOs = $this->memberDAO->getMembersWithActivity(true);
        foreach ($activeMemberEOs as $activeMemberEO) {
            $wgEO = $activeMemberEO->ref(WorkingGroupMetadata::$tableName, MemberMetadata::$workingGroupId);
            $wgIndex = $wgEO ? $wgIndexes[$wgEO[WorkingGroupMetadata::$workingGroupId]] : $i;
            $memberWgData[$wgIndex] = $memberWgData[$wgIndex] + 1;
        }

        $memberWgDataOTO = $this->statsTOFiller->fillStatsData(new StatsDataOTO(), $wgNames, $memberWgData);
        return $memberWgDataOTO;
    }
}