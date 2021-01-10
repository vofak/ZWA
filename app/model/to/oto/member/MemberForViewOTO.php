<?php

declare(strict_types=1);


namespace App\model\to\oto\member;

/**
 * Class MemberForViewOTO
 * @package App\model\to\oto\member
 */
class MemberForViewOTO extends MemberOTO
{
    private string $gender;
    private bool $active;

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}