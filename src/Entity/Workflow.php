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
    public Users $users;

    #[ManyToOne(targetEntity: Internship::class, inversedBy: "workflow")]
    #[JoinColumn(name: "ID_Internship", referencedColumnName: "ID_Internship")]
    public Internship $internship;
}