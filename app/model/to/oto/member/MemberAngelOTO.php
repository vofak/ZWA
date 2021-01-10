<?php

declare(strict_types=1);


namespace App\model\to\oto\member;


/**
 * Class MemberAngelOTO
 * @package App\model\to\oto\member
 */
class MemberAngelOTO
{
    private int $angelId;
    private string $name;
    private ?string $nickname;

    /**
     * @return int
     */
    public function getAngelId(): int
    {
        return $this->angelId;
    }

    /**
     * @param int $angelId
     */
    public function setAngelId(int $angelId): void
    {
        $this->angelId = $angelId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

}