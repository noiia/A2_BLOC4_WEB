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

#[Entity]
#[Table('Internship')]
class Internship
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: Types::INTEGER)]
    private int $ID_Internship;
    #[Column(type:Types::STRING, length: 50)]
    private string $Title;
    #[Column(type: Types::SMALLINT)]
    private int $Duration;
    #[Column(type: Types::DATE_MUTABLE)]
    private \DateTime $Starting_date;
    #[Column(type: Types::FLOAT, precision: 4, scale: 2)]
    private float $Hourly_rate;
    #[Column(type: Types::INTEGER)]
    private int $Hour_per_week;
    #[Column(type: Types::INTEGER)]
    private int $Max_places;
    #[Column(type:Types::STRING, length: 300)]
    private string $Advantages;
    #[Column]
    private int $Worktime;
    #[Column(type: Types::TEXT)]
    private string $Description;
    #[Column(type: Types::BOOLEAN)]
    private bool $Del;

    #[OneToMany(targetEntity: Appliement_WishList::class, mappedBy:'internships')]
    private Collection $appliement_wishlist;
    public function getAppliementWishlist(): Collection
    {
        return $this->appliement_wishlist;
    }
    #[JoinTable(name: "seek")]
    #[JoinColumn(name: 'id_internship', referencedColumnName: 'ID_Internship')]
    #[InverseJoinColumn(name: 'id_skill', referencedColumnName: 'ID_skills')]
    #[ManyToMany(targetEntity: Skills::class)]
    private Collection $skills;

    public function getSkills(): Collection
    {
        return $this->skills;
    }

    #[ManyToOne(targetEntity: Company::class, inversedBy: "internships")]
    #[JoinColumn(name: "ID_company", referencedColumnName: "ID_company")]
    public ?Company $companies;
    #[ManyToOne(targetEntity: Location::class, inversedBy: 'internships')]
    #[JoinColumn(name: 'ID_location', referencedColumnName: 'ID_location', nullable: false)]
    public Location $locations;
    #[ManyToOne(targetEntity: Promotion::class, inversedBy: "internships")]
    #[JoinColumn(name: "ID_promotion", referencedColumnName: "ID_promotion", unique: false)]
    public Promotion $promotions;

    public function __construct() {
        $this->appliement_wishlist = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function toString() : string
    {
        return $this->Title;
    }

    public function getIDInternship(): int
    {
        return $this->ID_Internship;
    }

    public function setIDInternship(int $ID_Internship): void
    {
        $this->ID_Internship = $ID_Internship;
    }

    public function getTitle(): string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): void
    {
        $this->Title = $Title;
    }

    public function getDuration(): int
    {
        return $this->Duration;
    }

    public function setDuration(int $Duration): void
    {
        $this->Duration = $Duration;
    }

    public function getStartingDate(): string
    {
        return $this->Starting_date->format('Y-m-d');
    }

    public function setStartingDate(\DateTime $Starting_date): void
    {
        $this->Starting_date = $Starting_date;
    }

    public function getHourlyRate(): float
    {
        return $this->Hourly_rate;
    }

    public function setHourlyRate(float $Hourly_rate): void
    {
        $this->Hourly_rate = $Hourly_rate;
    }
    public function getHourPerWeek(): int
    {
        return $this->Hour_per_week;
    }

    public function setHourPerWeek(int $Hour_per_week): void
    {
        $this->Hour_per_week = $Hour_per_week;
    }

    public function getMaxPlaces(): int
    {
        return $this->Max_places;
    }

    public function setMaxPlaces(int $Max_places): void
    {
        $this->Max_places = $Max_places;
    }

    public function getAdvantages(): string
    {
        return $this->Advantages;
    }

    public function setAdvantages(string $Advantages): void
    {
        $this->Advantages = $Advantages;
    }

    public function getWorktime(): int
    {
        return $this->Worktime;
    }

    public function setWorktime(int $Worktime): void
    {
        $this->Worktime = $Worktime;
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

}