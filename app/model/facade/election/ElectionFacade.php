<?php

declare(strict_types=1);


namespace App\model\facade\election;


use App\model\common\utils\MemberUtils;
use App\model\core\security\SecurityMetadata;
use App\model\core\security\SecurityResolver;
use App\model\dal\dao\BoardDAO;
use App\model\dal\dao\ElectionDAO;
use App\model\dal\dao\MemberDAO;
use App\model\dal\metadata\BoardPositionMetadata;
use App\model\dal\metadata\ElectionBoardPositionMetadata;
use App\model\dal\metadata\ElectionMetadata;
use App\model\dal\metadata\MemberMetadata;
use App\model\dal\metadata\NominationMetadata;
use App\model\facade\common\CommonFacade;
use App\model\to\oto\election\ElectionAdminDetailNominationOTO;
use App\model\to\oto\election\ElectionAdminDetailOTO;
use App\model\to\oto\election\ElectionBrowseViewOTO;
use App\model\to\oto\election\ElectionDetailNominationOTO;
use App\model\to\oto\election\ElectionDetailOTO;
use App\model\to\oto\election\ElectionEditFormOTO;
use App\model\to\oto\election\ElectionForViewOTO;
use App\model\to\oto\election\NominationEditFormOTO;
use Exception;
use Nette\Security\User;

/**
 * Class ElectionFacade
 *
 * Component handling election related stuff in service layer
 *
 * @package App\model\facade\event
 */
class ElectionFacade extends CommonFacade
{
    private ElectionDAO $electionDAO;
    private BoardDAO $boardDAO;
    private MemberDAO $memberDAO;

    private ElectionTOFiller $electionTOFiller;

    /**
     * ElectionFacade constructor.
     * @param ElectionDAO $electionDAO
     * @param BoardDAO $boardDAO
     * @param MemberDAO $memberDAO
     * @param ElectionTOFiller $electionTOFiller
     * @param User $user
     * @param SecurityResolver $securityResolver
     */
    public function __construct(ElectionDAO $electionDAO, BoardDAO $boardDAO, MemberDAO $memberDAO, ElectionTOFiller $electionTOFiller, User $user, SecurityResolver $securityResolver)
    {
        parent::__construct($user, $securityResolver);
        $this->electionDAO = $electionDAO;
        $this->boardDAO = $boardDAO;
        $this->memberDAO = $memberDAO;

        $this->electionTOFiller = $electionTOFiller;
    }

    # ELECTION

    /**
     * @param int $electionId election id
     * @return ElectionDetailOTO OTO with info about a single election
     * @throws Exception
     */
    public function getElectionDetail(int $electionId): ElectionDetailOTO
    {
        $this->checkPermission(SecurityMetadata::electionResource, SecurityMetadata::$viewAction);

        $electionEO = $this->electionDAO->getElection($electionId);

        $userId = $this->getUser()->getId();
        $nominationEOs = $this->electionDAO->getNominations($electionId, null, $userId);
        $nominations = array();
        foreach ($nominationEOs as $nominationEO) {
            if (isset($nominations[$nominationEO[NominationMetadata::$boardPositionId]])) {
                $nomination = $nominations[$nominationEO[NominationMetadata::$boardPositionId]];
                $nomination->setCount($nomination->getCount() + 1);
                if ($nominationEO[NominationMetadata::$note]) {
                    $descriptions = $nomination->getDescriptions();
                    $descriptions[] = $nominationEO[NominationMetadata::$note];
                    $nomination->setDescriptions($descriptions);
                }
            }
            else {
                $boardPositionEO = $nominationEO->ref(BoardPositionMetadata::$tableName, NominationMetadata::$boardPositionId);
                $nomination = $this->electionTOFiller->fillElectionDetailNomination(new ElectionDetailNominationOTO(), $boardPositionEO[BoardPositionMetadata::$name], 1, array());
                if ($nominationEO[NominationMetadata::$note]) {
                    $descriptions = $nomination->getDescriptions();
                    $descriptions[] = $nominationEO[NominationMetadata::$note];
                    $nomination->setDescriptions($descriptions);
                }
                $nominations[$nominationEO[NominationMetadata::$boardPositionId]] = $nomination;
            }
        }

        $electionDetailOTO = $this->electionTOFiller->fillElectionDetail(new ElectionDetailOTO(), $electionEO, $nominations);
        return $electionDetailOTO;
    }

    /**
     * @param int $electionId election id
     * @return ElectionAdminDetailOTO OTO with sensitive info about a single election
     * @throws Exception
     */
    public function getElectionAdminDetail(int $electionId): ElectionAdminDetailOTO
    {
        // todo maybe add to classic detail as a optional second tab
        $this->checkPermission(SecurityMetadata::electionResource, SecurityMetadata::$viewSensitiveAction);

        $electionEO = $this->electionDAO->getElection($electionId);
        $nominations = array();
        foreach ($this->electionDAO->getNominations($electionId, null, null) as $nominationEO) {
            $electionAdminDetailNominationOTO = $this->electionTOFiller->fillElectionAdminDetailNomination(new ElectionAdminDetailNominationOTO(), $nominationEO);
            $nominations[] = $electionAdminDetailNominationOTO;
        }

        $electionAdminDetail = $this->electionTOFiller->fillElectionAdminDetail(new ElectionAdminDetailOTO(), $electionEO, $nominations);
        return $electionAdminDetail;
    }

    /**
     * @return ElectionBrowseViewOTO OTO with basic info about all elections
     * @throws Exception
     */
    public function getElectionBrowseView(): ElectionBrowseViewOTO
    {
        $this->checkPermission(SecurityMetadata::electionResource, SecurityMetadata::$viewAction);

        $electionEOs = $this->electionDAO->getElections();
        $electionForViewOTOs = array();
        foreach ($electionEOs as $electionEO) {
            $electionForViewOTO = $this->electionTOFiller->fillElectionForView(new ElectionForViewOTO(), $electionEO);
            $electionForViewOTOs[] = $electionForViewOTO;
        }
        $createElectionPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::electionResource, SecurityMetadata::$createAction);
        $editElectionPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::electionResource, SecurityMetadata::$editAction);
        $deleteElectionPermissionLevel = $this->resolvePermissionLevel(SecurityMetadata::electionResource, SecurityMetadata::$deleteAction);

        $electionBrowseViewOTO = $this->electionTOFiller->fillElectionBrowseView(new ElectionBrowseViewOTO(), $electionForViewOTOs, $createElectionPermissionLevel, $editElectionPermissionLevel, $deleteElectionPermissionLevel);
        return $electionBrowseViewOTO;
    }

    /**
     * @return ElectionEditFormOTO OTO with info needed for edit/create form
     */
    public function getElectionEditForm(): ElectionEditFormOTO
    {
        $boardPositionOptions = array();
        $boardPositions = $this->boardDAO->getBoardPositions();
        foreach ($boardPositions as $boardPositionEO) {
            $boardPositionId = $boardPositionEO[BoardPositionMetadata::$boardPositionId];
            $boardPositionOptions[$boardPositionId] = $boardPositionEO[BoardPositionMetadata::$name];
        }

        $electionEditFormOTO = $this->electionTOFiller->fillElectionEditForm(new ElectionEditFormOTO(), $boardPositionOptions);
        return $electionEditFormOTO;
    }

    /**
     * @param int $electionId election id
     * @return array default values for election edit form
     */
    public function getElectionForForm(int $electionId): array
    {
        $electionEO = $this->electionDAO->getElection($electionId);
        $electionArray = $electionEO->toArray();

        $electionBoardPositions = $electionEO->related(ElectionBoardPositionMetadata::$tableName, ElectionBoardPositionMetadata::$electionId)->fetchAll();
        $electionBoardPositionArray = array();
        foreach ($electionBoardPositions as $electionBoardPositionEO) {
            $boardPositionId = $electionBoardPositionEO[ElectionBoardPositionMetadata::$boardPositionId];
            $electionBoardPositionArray[] = $boardPositionId;
        }
        $electionArray['positions'] = $electionBoardPositionArray;
        return $electionArray;
    }

    /**
     * @param array $electionArray election array to be added
     * @return int id of the added election
     * @throws Exception
     */
    public function addElection(array $electionArray): int
    {
        $this->checkPermission(SecurityMetadata::electionResource, SecurityMetadata::$createAction);

        $boardPositionIdsArray = array();
        if (array_key_exists('positions', $electionArray)) {
            $boardPositionIdsArray = $electionArray['positions'];
            unset($electionArray['positions']);
        }
        $electionEO = $this->electionDAO->insertElection($electionArray);
        $electionId = $electionEO[ElectionMetadata::$electionId];

        foreach ($boardPositionIdsArray as $boardPositionId) {
            $this->electionDAO->insertElectionBoardPosition(array(
                ElectionBoardPositionMetadata::$electionId => $electionId,
                ElectionBoardPositionMetadata::$boardPositionId => $boardPositionId
            ));
        }
        return $electionId;
    }

    /**
     * @param array $electionArray election array to be updated
     * @return int od of the updated election
     * @throws Exception
     */
    public function updateElection(array $electionArray): int
    {
        $this->checkPermission(SecurityMetadata::electionResource, SecurityMetadata::$editAction);

        $electionId = $electionArray[ElectionMetadata::$electionId];
        $electionEO = $this->electionDAO->getElection($electionId);

        $boardPositionIdsArray = array();
        if (array_key_exists('positions', $electionArray)) {
            $boardPositionIdsArray = $electionArray['positions'];
            unset($electionArray['positions']);
        }
        $electionBoardPositions = $electionEO->related(ElectionBoardPositionMetadata::$tableName, ElectionBoardPositionMetadata::$electionId)->fetchAll();
        // add election board positions that do not yet exist
        foreach ($boardPositionIdsArray as $boardPositionId) {
            $alreadyExists = false;
            foreach ($electionBoardPositions as $electionBoardPositionEO) {
                $existingBoardPositionId = $electionBoardPositionEO[ElectionBoardPositionMetadata::$boardPositionId];
                if ($existingBoardPositionId == $boardPositionId) {
                    $alreadyExists = true;
                    break;
                }
            }
            if (!$alreadyExists) {
                $this->electionDAO->insertElectionBoardPosition(array(
                    ElectionBoardPositionMetadata::$electionId => $electionId,
                    ElectionBoardPositionMetadata::$boardPositionId => $boardPositionId
                ));
            }
        }

        // remove election board positions that are not required
        foreach ($electionBoardPositions as $electionBoardPositionEO) {
            $existingBoardPositionId = $electionBoardPositionEO[ElectionBoardPositionMetadata::$boardPositionId];
            $isRequired = false;
            foreach ($boardPositionIdsArray as $boardPositionId) {
                if ($existingBoardPositionId == $boardPositionId) {
                    $isRequired = true;
                    break;
                }
            }
            if (!$isRequired) {
                $electionBoardPositionEO->delete();
            }
        }

        $electionEO->update($electionArray);
        return $electionId;
    }

    /**
     * @param int $electionId election id
     * @throws Exception
     */
    public function deleteElection(int $electionId): void
    {
        $this->checkPermission(SecurityMetadata::electionResource, SecurityMetadata::$deleteAction);

        $this->electionDAO->deleteElection($electionId);
    }

    # NOMINATION

    /**
     * @param int $electionId election id
     * @return NominationEditFormOTO OTO for nomination create/edit form
     */
    public function getNominationEditForm(int $electionId): NominationEditFormOTO
    {
        $electionEO = $this->electionDAO->getElection($electionId);
        $electionBoardPositionEOs = $electionEO->related(ElectionBoardPositionMetadata::$tableName, ElectionBoardPositionMetadata::$electionId);

        $boardPositionOptions = array();
        foreach ($electionBoardPositionEOs as $electionBoardPositionEO) {
            $boardPositionEO = $electionBoardPositionEO->ref(BoardPositionMetadata::$tableName, ElectionBoardPositionMetadata::$boardPositionId);
            $boardPositionOptions[$boardPositionEO[BoardPositionMetadata::$boardPositionId]] = $boardPositionEO[BoardPositionMetadata::$name];
        }

        $memberEOs = $this->memberDAO->getMembersWithNominationRight(true);
        $nomineeOptions = array();
        foreach ($memberEOs as $memberEO) {
            $nomineeOptions[$memberEO[MemberMetadata::$memberId]] = MemberUtils::resolveDisplayName($memberEO);
        }

        $nominationEditFormOTO = $this->electionTOFiller->fillNominationEditForm(new NominationEditFormOTO(), $boardPositionOptions, $nomineeOptions);
        return $nominationEditFormOTO;
    }

    /**
     * @param array $nominationArray nomination array to be added
     * @return int id of the added nomination
     */
    public function addNomination(array $nominationArray): int
    {
        $nominationArray[NominationMetadata::$proposerId] = $this->getUser()->getId();
        $nominationEO = $this->electionDAO->insertNomination($nominationArray);
        return $nominationEO[NominationMetadata::$nominationId];
    }
}