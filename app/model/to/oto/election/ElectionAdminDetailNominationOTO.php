<?php


namespace App\model\to\oto\election;

/**
 * Class ElectionAdminDetailNominationOTO
 * @package App\model\to\oto\election
 */
class ElectionAdminDetailNominationOTO
{
    private int $nominationId;
    private string $nomineeName;
    private string $boardPositionName;
    private string $proposerName;
    private ?string $description;

    /**
     * @return int
     */
    public function getNominationId(): int
    {
        return $this->nominationId;
    }

    /**
     * @param int $nominationId
     */
    public function setNominationId(int $nominationId): void
    {
        $this->nominationId = $nominationId;
    }

    /**
     * @return string
     */
    public function getNomineeName(): string
    {
        return $this->nomineeName;
    }

    /**
     * @param string $nomineeName
     */
    public function setNomineeName(string $nomineeName): void
    {
        $this->nomineeName = $nomineeName;
    }

    /**
     * @return string
     */
    public function getBoardPositionName(): string
    {
        return $this->boardPositionName;
    }

    /**
     * @param string $boardPositionName
     */
    public function setBoardPositionName(string $boardPositionName): void
    {
        $this->boardPositionName = $boardPositionName;
    }

    /**
     * @return string
     */
    public function getProposerName(): string
    {
        return $this->proposerName;
    }

    /**
     * @param string $proposerName
     */
    public function setProposerName(string $proposerName): void
    {
        $this->proposerName = $proposerName;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}