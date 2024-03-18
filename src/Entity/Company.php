<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;


#[Entity]
#[Table('Company')]
class Company
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private ?int $ID_company = null;
    #[Column(type:Types::STRING, length: 50)]
    private string $Name;
    #[Column(type:Types::STRING, length: 50)]
    private string $SIRET;
    #[Column(type: Types::DATE_MUTABLE)]
    private \DateTime $Creation_date;
    #[Column(type:Types::STRING, length: 50)]
    private string $Staff;
    #[Column(type:Types::STRING, length: 50)]
    private string $Type;
    #[Column(type: Types::TEXT)]
    private string $Company_description;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    #[ManyToOne(targetEntity: Sector::class, inversedBy: "companies")]
    #[JoinColumn(name: "ID_sector", referencedColumnName: "ID_sector")]
    private ?Sector $sector;
    #[OneToMany(targetEntity: Rate::class, mappedBy:'companies')]
    private Collection $rates;
    #[JoinTable(name: "Manage_company")]
    #[JoinColumn(name: 'id_company', referencedColumnName: 'ID_company', unique: false)]
    #[InverseJoinColumn(name: 'id_users', referencedColumnName: 'ID_users', unique: false)]
    #[ManyToMany(targetEntity: Users::class, inversedBy: "companies")]
    private Collection $users;
    #[OneToMany(targetEntity: Internship::class, mappedBy:'companies')]
    private Collection $internships;
    #[OneToOne(targetEntity: Location::class, inversedBy: 'companies')]
    #[JoinColumn(name: 'id_location', referencedColumnName: 'ID_location')]
    private Collection $locations;
    public function __construct()
    {
        $this->rates = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->internships = new ArrayCollection();
    }


    public function getIDCompany(): int
    {
        return $this->ID_company;
    }

    public function setIDCompany(int $ID_company): void
    {
        $this->ID_company = $ID_company;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    public function getSIRET(): string
    {
        return $this->SIRET;
    }

    public function setSIRET(string $SIRET): void
    {
        $this->SIRET = $SIRET;
    }

    public function getCreationDate(): \DateTime
    {
        return $this->Creation_date;
    }

    public function setCreationDate(\DateTime $Creation_date): void
    {
        $this->Creation_date = $Creation_date;
    }

    public function getStaff(): string
    {
        return $this->Staff;
    }

    public function setStaff(string $Staff): void
    {
        $this->Staff = $Staff;
    }

    public function getType(): string
    {
        return $this->Type;
    }

    public function setType(string $Type): void
    {
        $this->Type = $Type;
    }

    public function getCompanyDescription(): string
    {
        return $this->Company_description;
    }

    public function setCompanyDescription(string $Company_description): void
    {
        $this->Company_description = $Company_description;
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