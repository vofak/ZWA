<?php


namespace App\model\to\oto\election;

/**
 * Class ElectionAdminDetailOTO
 * @package App\model\to\oto\election
 */
class ElectionAdminDetailOTO
{
    private string $name;
    private array $nominations;

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
     * @return array
     */
    public function getNominations(): array
    {
        return $this->nominations;
    }

    /**
     * @param array $nominations
     */
    public function setNominations(array $nominations): void
    {
        $this->nominations = $nominations;
    }

}