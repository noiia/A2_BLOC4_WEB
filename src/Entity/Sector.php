<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('Sector')]
class Sector
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_sector;
    #[Column(type: Types::STRING, length: 50)]
    private string $Name;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    #[ManyToOne(targetEntity: Company::class, inversedBy: 'sector')]
    #[JoinColumn(name: 'ID_company', referencedColumnName: 'ID_company')]
    private ?Company $companies;

    public function getIDSector(): int
    {
        return $this->ID_sector;
    }

    public function setIDSector(int $ID_sector): void
    {
        $this->ID_sector = $ID_sector;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    public function isDel(): bool
    {
        return $this->Del;
    }

    public function setDel(bool $Del): void
    {
        $this->Del = $Del;
    }
}