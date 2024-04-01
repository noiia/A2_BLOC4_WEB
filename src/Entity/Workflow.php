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
#[Table]
class Workflow
{
    /*
     *  Status:
     *  1 : postulation
     *  2 : accepted
     *  3 : refused
     *  4 : ended
     */
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_Workflow;
    #[Column(type: Types::SMALLINT)]
    private int $Status;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;

    #[ManyToOne(targetEntity: Users::class, inversedBy: "workflow")]
    #[JoinColumn(name: "ID_users", referencedColumnName: "ID_users")]
    private Users $users;

    #[ManyToOne(targetEntity: Internship::class, inversedBy: "workflow")]
    #[JoinColumn(name: "ID_Internship", referencedColumnName: "ID_Internship")]
    private Internship $internship;

    public function getIDWorkflow(): int
    {
        return $this->ID_Workflow;
    }

    public function setIDWorkflow(int $ID_Workflow): void
    {
        $this->ID_Workflow = $ID_Workflow;
    }

    public function getStatus(): int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
    }

    public function isDel(): bool
    {
        return $this->Del;
    }

    public function setDel(bool $Del): void
    {
        $this->Del = $Del;
    }

    public function getUsers(): Users
    {
        return $this->users;
    }

    public function setUsers(Users $users): void
    {
        $this->users = $users;
    }

    public function getInternship(): Internship
    {
        return $this->internship;
    }

    public function setInternship(Internship $internship): void
    {
        $this->internship = $internship;
    }
}