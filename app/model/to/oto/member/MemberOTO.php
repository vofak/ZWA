<?php

declare(strict_types=1);


namespace App\model\to\oto\member;


use Nette\Utils\DateTime;

/**
 * Class MemberOTO
 * @package App\model\to\oto\member
 */
abstract class MemberOTO
{
    private string $imageSrcPath;
    private int $memberId;
    private string $name;
    private ?string $nickname = null;
    private string $email;
    private ?string $wg = null;
    private ?string $faculty = null;
    private ?string $phoneNumber = null;
    private ?string $shirtSize = null;
    private string $rankName;
    private ?DateTime $joinedDate = null;
    private ?DateTime $birthday = null;
    private ?string $skype = null;
    private ?string $facebook = null;
    private ?MemberAngelOTO $angel;

    /**
     * @return string
     */
    public function getImageSrcPath(): string
    {
        return $this->imageSrcPath;
    }

    /**
     * @param string $imageSrcPath
     */
    public function setImageSrcPath(string $imageSrcPath): void
    {
        $this->imageSrcPath = $imageSrcPath;
    }

    /**
     * @return int
     */
    public function getMemberId(): int
    {
        return $this->memberId;
    }

    /**
     * @param int $memberId
     */
    public function setMemberId(int $memberId): void
    {
        $this->memberId = $memberId;
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

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getWg(): ?string
    {
        return $this->wg;
    }

    /**
     * @param string|null $wg
     */
    public function setWg(?string $wg): void
    {
        $this->wg = $wg;
    }

    /**
     * @return string|null
     */
    public function getFaculty(): ?string
    {
        return $this->faculty;
    }

    /**
     * @param string|null $faculty
     */
    public function setFaculty(?string $faculty): void
    {
        $this->faculty = $faculty;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getShirtSize(): ?string
    {
        return $this->shirtSize;
    }

    /**
     * @param string|null $shirtSize
     */
    public function setShirtSize(?string $shirtSize): void
    {
        $this->shirtSize = $shirtSize;
    }

    /**
     * @return string
     */
    public function getRankName(): string
    {
        return $this->rankName;
    }

    /**
     * @param string $rankName
     */
    public function setRankName(string $rankName): void
    {
        $this->rankName = $rankName;
    }

    /**
     * @return DateTime|null
     */
    public function getJoinedDate(): ?DateTime
    {
        return $this->joinedDate;
    }

    /**
     * @param DateTime|null $joinedDate
     */
    public function setJoinedDate(?DateTime $joinedDate): void
    {
        $this->joinedDate = $joinedDate;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    /**
     * @param DateTime|null $birthday
     */
    public function setBirthday(?DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string|null
     */
    public function getSkype(): ?string
    {
        return $this->skype;
    }

    /**
     * @param string|null $skype
     */
    public function setSkype(?string $skype): void
    {
        $this->skype = $skype;
    }

    /**
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    /**
     * @param string|null $facebook
     */
    public function setFacebook(?string $facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return MemberAngelOTO|null
     */
    public function getAngel(): ?MemberAngelOTO
    {
        return $this->angel;
    }

    /**
     * @param MemberAngelOTO|null $angel
     */
    public function setAngel(?MemberAngelOTO $angel): void
    {
        $this->angel = $angel;
    }
}