<?php

declare(strict_types=1);


namespace App\model\facade\election;


use App\model\common\utils\MemberUtils;
use App\model\dal\metadata\BoardPositionMetadata;
use App\model\dal\metadata\ElectionMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\dal\metadata\NominationMetadata;
use App\model\to\oto\election\ElectionAdminDetailNominationOTO;
use App\model\to\oto\election\ElectionAdminDetailOTO;
use App\model\to\oto\election\ElectionBrowseViewOTO;
use App\model\to\oto\election\ElectionDetailNominationOTO;
use App\model\to\oto\election\ElectionDetailOTO;
use App\model\to\oto\election\ElectionEditFormOTO;
use App\model\to\oto\election\ElectionForViewOTO;
use App\model\to\oto\election\NominationEditFormOTO;
use Nette\Database\Table\ActiveRow;

/**
 * Class ElectionTOFiller
 *
 * Component filling election related transfer objects
 *
 * @package App\model\facade\election
 */
class ElectionTOFiller
{

    public function fillElectionDetail(ElectionDetailOTO $electionDetailOTO, ActiveRow $electionEO, array $nominations): ElectionDetailOTO
    {
        $electionDetailOTO->setElectionName($electionEO[ElectionMetadata::$name]);
        $electionDetailOTO->setNominations($nominations);

        return $electionDetailOTO;
    }

    public function fillElectionDetailNomination(ElectionDetailNominationOTO $electionDetailNominationOTO, string $boardPositionName, int $nominationCount, array $descriptions): ElectionDetailNominationOTO
    {
        $electionDetailNominationOTO->setBoardPositionName($boardPositionName);
        $electionDetailNominationOTO->setCount($nominationCount);
        $electionDetailNominationOTO->setDescriptions($descriptions);

        return $electionDetailNominationOTO;
    }

    public function fillElectionAdminDetail(ElectionAdminDetailOTO $electionAdminDetailOTO, ActiveRow $electionEO, array $nominations): ElectionAdminDetailOTO
    {
        $electionAdminDetailOTO->setName($electionEO[ElectionMetadata::$name]);
        $electionAdminDetailOTO->setNominations($nominations);

        return $electionAdminDetailOTO;
    }

    public function fillElectionAdminDetailNomination(ElectionAdminDetailNominationOTO $electionAdminDetailNominationOTO, ActiveRow $nominationEO): ElectionAdminDetailNominationOTO
    {
        $nomineeEO = $nominationEO->ref(MemberMetadata::$tableName, NominationMetadata::$nomineeId);
        $proposerEO = $nominationEO->ref(MemberMetadata::$tableName, NominationMetadata::$proposerId);
        $boardPositionEO = $nominationEO->ref(NominationMetadata::$tableName, NominationMetadata::$boardPositionId);
        $electionAdminDetailNominationOTO->setNominationId($nominationEO[NominationMetadata::$nominationId]);
        $electionAdminDetailNominationOTO->setNomineeName(MemberUtils::resolveDisplayName($nomineeEO));
        $electionAdminDetailNominationOTO->setBoardPositionName($boardPositionEO[BoardPositionMetadata::$name]);
        $electionAdminDetailNominationOTO->setProposerName(MemberUtils::resolveDisplayName($proposerEO));
        $electionAdminDetailNominationOTO->setDescription($nominationEO[NominationMetadata::$note]);

        return $electionAdminDetailNominationOTO;
    }

    public function fillElectionForView(ElectionForViewOTO $electionForViewOTO, ActiveRow $electionEO): ElectionForViewOTO
    {
        $electionForViewOTO->setElectionId($electionEO[ElectionMetadata::$electionId]);
        $electionForViewOTO->setName($electionEO[ElectionMetadata::$name]);
        $electionForViewOTO->setPublished(boolval($electionEO[ElectionMetadata::$isPublished]));
        $electionForViewOTO->setStartDate($electionEO[ElectionMetadata::$startDate]);
        $electionForViewOTO->setEndDate($electionEO[ElectionMetadata::$endDate]);

        return $electionForViewOTO;
    }

    public function fillElectionBrowseView(ElectionBrowseViewOTO $electionBrowseViewOTO, array $electionForViewOTOs, string $createElectionPermissionLevel, string $editElectionPermissionLevel, string $deleteElectionPermissionLevel)
    {
        $electionBrowseViewOTO->setElectionForViewOTOs($electionForViewOTOs);
        $electionBrowseViewOTO->setCreateElectionPermissionLevel($createElectionPermissionLevel);
        $electionBrowseViewOTO->setEditElectionPermissionLevel($editElectionPermissionLevel);
        $electionBrowseViewOTO->setDeleteElectionPermissionLevel($deleteElectionPermissionLevel);

        return $electionBrowseViewOTO;
    }

    public function fillElectionEditForm(ElectionEditFormOTO $electionEditFormOTO, array $boardPositionOptions)
    {
        $electionEditFormOTO->setBoardPositionOptions($boardPositionOptions);

        return $electionEditFormOTO;
    }

    public function fillNominationEditForm(NominationEditFormOTO $nominationEditFormOTO, array $boardPositionOptions, array $nomineeOptions)
    {
        $nominationEditFormOTO->setBoardPositionOptions($boardPositionOptions);
        $nominationEditFormOTO->setNomineeOptions($nomineeOptions);

        return $nominationEditFormOTO;
    }
}