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
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table('Users')]
/**
 * @ORM\Entity()
 * @ORM\Table(name="User")
 */
class Users
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_users;
    #[Column(type: Types::STRING, length: 50)]
    private string $Login;
    #[Column(type: Types::STRING, length: 50)]
    private string $Password;
    #[Column(type: Types::STRING, length: 50)]
    private string $Name;
    #[Column(type: Types::STRING, length: 50)]
    private string $Surname;
    #[Column(type: Types::DATE_MUTABLE)]
    private \DateTime $Birth_date;
    #[Column(type: Types::TEXT)]
    private string $Profile_Description;
    #[Column(type: Types::STRING, length: 50)]
    private string $Email;
    #[Column(type: Types::SMALLINT)]
    private int $Role;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    #[OneToMany(targetEntity: Rate::class, mappedBy:'users')]
    private Collection $rates;
    #[JoinTable(name: "Have_proms")]
    #[JoinColumn(name: 'id_users', referencedColumnName: 'ID_users')]
    #[InverseJoinColumn(name: 'id_promotions', referencedColumnName: 'ID_promotion', unique: false)]
    #[ManyToMany(targetEntity: Promotion::class, inversedBy: "users")]
    private Collection $promotions;
    #[OneToMany(targetEntity: Appliement_WishList::class, mappedBy:'users')]
    private Collection $wishlists_appliement;
    /*#[ManyToMany(targetEntity: CompanyManagement::class, mappedBy: 'users')]
    private Collection $companies;*/
    public function __construct()
    {
        $this->rates = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->wishlists_appliement = new ArrayCollection();
        //$this->companies = new ArrayCollection();
    }
    public function getIDUsers(): int
    {
        return $this->ID_users;
    }

    public function setIDUsers(int $ID_users): void
    {
        $this->ID_users = $ID_users;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    public function getSurname(): string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): void
    {
        $this->Surname = $Surname;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->Birth_date;
    }

    public function setBirthDate(\DateTime $Birth_date): void
    {
        $this->Birth_date = $Birth_date;
    }

    public function getProfileDescription(): string
    {
        return $this->Profile_Description;
    }

    public function setProfileDescription(string $Profile_Description): void
    {
        $this->Profile_Description = $Profile_Description;
    }

    public function getEmail(): string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    public function getRole(): int
    {
        return $this->Role;
    }

    public function setRole(int $Role): void
    {
        $this->Role = $Role;
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