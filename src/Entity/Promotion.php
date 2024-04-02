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
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('Promotion')]
class Promotion
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_promotion;
    #[Column(type: Types::STRING, length: 50)]
    private string $Name;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    
    #[ManyToOne(targetEntity: Location::class, inversedBy: "promotions")]
    #[JoinColumn(name: "ID_location", referencedColumnName: "ID_location")]
    public Location $location;

    #[ManyToMany(targetEntity: Users::class, mappedBy: 'promotions')]
    private Collection $users;
    #[OneToMany(targetEntity: Internship::class, mappedBy: 'companies')]
    private Collection $internships;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->internships = new ArrayCollection();
    }

    public function getIDPromotion(): int
    {
        return $this->ID_promotion;
    }

    public function setIDPromotion(int $ID_promotion): void
    {
        $this->ID_promotion = $ID_promotion;
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