<?php

declare(strict_types=1);


namespace App\model\dal\dao;


use App\model\dal\dao\common\CommonDAO;
use App\model\dal\metadata\FacultyMetadata;
use App\model\dal\metadata\LanguageMetadata;
use App\model\dal\metadata\RankMetadata;
use App\model\dal\metadata\WorkingGroupMetadata;
use Nette\Database\Table\ActiveRow;

/**
 * Class SystemDAO
 *
 * DAO working with entities concerning common entities
 *
 * @package App\model\dal\dao
 */
class SystemDAO extends CommonDAO
{

    // RANK
    /**
     * @param int $rankId rank id
     * @return ActiveRow rank EO
     */
    public function getRank(int $rankId): ActiveRow
    {
        return $this->getDatabase()
            ->table(RankMetadata::$tableName)
            ->get($rankId);
    }

    /**
     * @param bool|null $active activity flag
     * @return array array of all ranks with given activity flag
     */
    public function getRanks(bool $active = null): array
    {
        $query = $this->getDatabase()
            ->table(RankMetadata::$tableName);

        if ($active != null) {
            $query->where(RankMetadata::$isActive, $active);
        }

        return $query->fetchAll();
    }

    // FACULTY

    /**
     * @param int $facultyId faculty id
     * @return ActiveRow faculty EO
     */
    public function getFaculty(int $facultyId): ActiveRow
    {
        return $this->getDatabase()
            ->table(FacultyMetadata::$tableName)
            ->get($facultyId);
    }

    /**
     * @return array array of all existing faculties
     */
    public function getFaculties(): array
    {
        return $this->getDatabase()
            ->table(FacultyMetadata::$tableName)
            ->fetchAll();
    }

    // WG

    /**
     * @param int $wgId working group id
     * @return ActiveRow working group EO
     */
    public function getWorkingGroup(int $wgId): ActiveRow
    {
        return $this->getDatabase()
            ->table(WorkingGroupMetadata::$tableName)
            ->get($wgId);
    }

    /**
     * @return array array of all existing working groups
     */
    public function getWorkingGroups(): array
    {
        return $this->getDatabase()
            ->table(WorkingGroupMetadata::$tableName)
            ->fetchAll();
    }

    // LANGUAGE

    /**
     * @param int $languageId language id
     * @return ActiveRow language EO
     */
    public function getLanguage(int $languageId): ActiveRow
    {
        return $this->getDatabase()
            ->table(LanguageMetadata::$tableName)
            ->get($languageId);
    }

    /**
     * @return array array of all existing languages
     */
    public function getLanguages(): array
    {
        return $this->getDatabase()
            ->table(LanguageMetadata::$tableName)
            ->fetchAll();
    }

}