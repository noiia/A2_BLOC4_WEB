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
#[Table('Appliement_WishList')]
class Appliement_WishList
{
    /*
     * Status :
     *  1 : Postulation
     *  2 : engaged
     *  3 : no engaged
     *  4 : finished internship
     *  5 : added to wishlist
     */
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_Appliement_Wishlist;
    #[Column(type: Types::SMALLINT)]
    private int $Status;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;
    #[ManyToOne(targetEntity: Users::class, inversedBy: "wishlists_appliement")]
    #[JoinColumn(name: "ID_users", referencedColumnName: "ID_users")]
    private ?Users $users;
    #[ManyToOne(targetEntity: Internship::class, inversedBy: "wishlists_appliement")]
    #[JoinColumn(name: "ID_Internship", referencedColumnName: "ID_Internship")]
    public ?Internship $internships;

    public function getIDUsers(): int
    {
        return $this->ID_Users;
    }

    public function setIDUsers(int $ID_Users): void
    {
        $this->ID_Users = $ID_Users;
    }

    public function getIDInternship(): int
    {
        return $this->ID_Internship;
    }

    public function setIDInternship(int $ID_Internship): void
    {
        $this->ID_Internship = $ID_Internship;
    }

    public function getStatus(): int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
    }

    public function isAccepted(): bool
    {
        return $this->Accepted;
    }

    public function setAccepted(bool $Accepted): void
    {
        $this->Accepted = $Accepted;
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