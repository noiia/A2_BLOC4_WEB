<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('Rate')]
class Rate
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_rate;
    #[Column(type: Types::SMALLINT)]
    private int $Note;
    #[Column(type: Types::STRING, length: 50)]
    private string $Description;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    #[ManyToOne(targetEntity: Company::class, inversedBy: "rates")]
    #[JoinColumn(name: "ID_company", referencedColumnName: "ID_company")]
    private ?Company $companies;
    #[ManyToOne(targetEntity: Users::class, inversedBy: "users")]
    #[JoinColumn(name: "ID_users", referencedColumnName: "ID_users")]
    public ?Users $users;

    public function getIDRate(): int
    {
        return $this->ID_rate;
    }

    public function setIDRate(int $ID_rate): void
    {
        $this->ID_rate = $ID_rate;
    }

    public function getNote(): int
    {
        return $this->Note;
    }

    public function setNote(int $Note): void
    {
        $this->Note = $Note;
    }

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }

    public function getDel(): bool
    {
        return $this->Del;
    }

    public function setDel(bool $Del): void
    {
        $this->Del = $Del;
    }

    public function setCompanies(?Company $companies): void
    {
        $this->companies = $companies;
    }

    public function setUsers(?Users $users): void
    {
        $this->users = $users;
    }

}