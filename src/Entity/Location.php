<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('Location')]
class Location
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_location;
    #[Column(type:Types::STRING, length: 50)]
    private string $City;
    #[Column(type:Types::STRING, length: 5)]
    private string $Zip_code;
    #[Column(type:Types::STRING, length: 2)]
    private string $Departement;
    #[Column(type:Types::BOOLEAN)]
    private bool $Del;
    #[OneToMany(targetEntity: Promotion::class, mappedBy:'location')]
    private Collection $promotions;
    #[OneToMany(targetEntity: Internship::class, mappedBy:'location')]
    private Collection $internships;
    #[OneToOne(targetEntity: Company::class, mappedBy: 'locations')]
    private Collection $companies;
    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->internships = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }
    public function getIDLocation(): int
    {
        return $this->ID_location;
    }

    public function setIDLocation(int $ID_location): void
    {
        $this->ID_location = $ID_location;
    }

    public function getCity(): string
    {
        return $this->City;
    }

    public function setCity(string $City): void
    {
        $this->City = $City;
    }

    public function getZipCode(): string
    {
        return $this->Zip_code;
    }

    public function setZipCode(string $Zip_code): void
    {
        $this->Zip_code = $Zip_code;
    }

    public function getDepartement(): string
    {
        return $this->Departement;
    }

    public function setDepartement(string $Departement): void
    {
        $this->Departement = $Departement;
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