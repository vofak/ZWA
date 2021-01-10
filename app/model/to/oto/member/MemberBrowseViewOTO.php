<?php


namespace App\model\to\oto\member;

/**
 * Class MemberBrowseViewOTO
 * @package App\model\to\oto\member
 */
class MemberBrowseViewOTO
{
    private array $memberForViewOTOs;
    private string $createMemberPermissionLevel;

    /**
     * @return array
     */
    public function getMemberForViewOTOs(): array
    {
        return $this->memberForViewOTOs;
    }

    /**
     * @param array $memberForViewOTOs
     */
    public function setMemberForViewOTOs(array $memberForViewOTOs): void
    {
        $this->memberForViewOTOs = $memberForViewOTOs;
    }

    /**
     * @return string
     */
    public function getCreateMemberPermissionLevel(): string
    {
        return $this->createMemberPermissionLevel;
    }

    /**
     * @param string $createMemberPermissionLevel
     */
    public function setCreateMemberPermissionLevel(string $createMemberPermissionLevel): void
    {
        $this->createMemberPermissionLevel = $createMemberPermissionLevel;
    }
}