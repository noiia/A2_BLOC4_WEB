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
    #[Column(type: Types::STRING, length: 512)]
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
    #[Column(type: Types::STRING, length: 200)]
    private string $Profile_picture_path = "";
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    #[OneToMany(targetEntity: Rate::class, mappedBy: 'users')]
    private Collection $rates;
    #[JoinTable(name: "Have_proms")]
    #[JoinColumn(name: 'id_users', referencedColumnName: 'ID_users')]
    #[InverseJoinColumn(name: 'id_promotions', referencedColumnName: 'ID_promotion', unique: false)]
    #[ManyToMany(targetEntity: Promotion::class, inversedBy: "users")]
    private Collection $promotions;

    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function setPromotions(Collection $Promotion)
    {
        $this->promotions = $Promotion;
    }

    #[JoinTable(name: "wishlist")]
    #[JoinColumn(name: 'id_users', referencedColumnName: 'ID_users')]
    #[InverseJoinColumn(name: 'id_internship', referencedColumnName: 'ID_Internship')]
    #[ManyToMany(targetEntity: Internship::class)]
    private Collection $wishlist;

    public function getWishlist(): Collection
    {
        return $this->wishlist;
    }

    public function setWishlist(array $wishlist): void
    {
        $this->wishlist = new ArrayCollection($wishlist);
    }

    #[OneToMany(targetEntity: Workflow::class, mappedBy: 'users')]
    private Collection $workflow;

    public function getWorkflow()
    {
        return $this->workflow;
    }

    /*#[ManyToMany(targetEntity: CompanyManagement::class, mappedBy: 'users')]
    private Collection $companies;*/
    public function __construct()
    {
        $this->rates = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->wishlist = new ArrayCollection();
        $this->workflow = new ArrayCollection();
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

    public function getLogin(): string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): void
    {
        $this->Login = $Login;
    }

    public function getPassword(): string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
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

    public function getProfilePicturePath(): string
    {
        return $this->Profile_picture_path;
    }

    public function setProfilePicturePath(string $Profile_picture_path): void
    {
        $this->Profile_picture_path = $Profile_picture_path;
    }

    public function isDel(): bool
    {
        return $this->Del;
    }

    public function setDel(bool $Del): void
    {
        $this->Del = $Del;
    }

    public function removeWishlist(Internship $wishlist): void
    {
        $this->wishlist->removeElement($wishlist);
    }
}