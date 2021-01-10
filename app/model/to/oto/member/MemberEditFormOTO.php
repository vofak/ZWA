<?php


namespace App\model\to\oto\member;

/**
 * Class MemberEditFormOTO
 * @package App\model\to\oto\member
 */
class MemberEditFormOTO
{
    private array $angelOptions;
    private array $rankOptions;
    private array $wgOptions;
    private array $roleOptions;
    private array $facultyOptions;
    private array $genderOptions;
    private array $languageOptions;
    private string $editSensitivePermissionLevel;

    /**
     * @return array
     */
    public function getAngelOptions(): array
    {
        return $this->angelOptions;
    }

    /**
     * @param array $angelOptions
     */
    public function setAngelOptions(array $angelOptions): void
    {
        $this->angelOptions = $angelOptions;
    }

    /**
     * @return array
     */
    public function getRankOptions(): array
    {
        return $this->rankOptions;
    }

    /**
     * @param array $rankOptions
     */
    public function setRankOptions(array $rankOptions): void
    {
        $this->rankOptions = $rankOptions;
    }

    /**
     * @return array
     */
    public function getWgOptions(): array
    {
        return $this->wgOptions;
    }

    /**
     * @param array $wgOptions
     */
    public function setWgOptions(array $wgOptions): void
    {
        $this->wgOptions = $wgOptions;
    }

    /**
     * @return array
     */
    public function getRoleOptions(): array
    {
        return $this->roleOptions;
    }

    /**
     * @param array $roleOptions
     */
    public function setRoleOptions(array $roleOptions): void
    {
        $this->roleOptions = $roleOptions;
    }

    /**
     * @return array
     */
    public function getFacultyOptions(): array
    {
        return $this->facultyOptions;
    }

    /**
     * @param array $facultyOptions
     */
    public function setFacultyOptions(array $facultyOptions): void
    {
        $this->facultyOptions = $facultyOptions;
    }

    /**
     * @return array
     */
    public function getGenderOptions(): array
    {
        return $this->genderOptions;
    }

    /**
     * @param array $genderOptions
     */
    public function setGenderOptions(array $genderOptions): void
    {
        $this->genderOptions = $genderOptions;
    }

    /**
     * @return array
     */
    public function getLanguageOptions(): array
    {
        return $this->languageOptions;
    }

    /**
     * @param array $languageOptions
     */
    public function setLanguageOptions(array $languageOptions): void
    {
        $this->languageOptions = $languageOptions;
    }

    /**
     * @return string
     */
    public function getEditSensitivePermissionLevel(): string
    {
        return $this->editSensitivePermissionLevel;
    }

    /**
     * @param string $editSensitivePermissionLevel
     */
    public function setEditSensitivePermissionLevel(string $editSensitivePermissionLevel): void
    {
        $this->editSensitivePermissionLevel = $editSensitivePermissionLevel;
    }
}