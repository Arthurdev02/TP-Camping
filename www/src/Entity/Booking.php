<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use App\Entity\Tarification;
use App\Entity\Accomodation;
use App\Entity\User;
use App\Entity\Season;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_end = null;

    #[ORM\Column]
    private ?int $nbre_adults = null;

    #[ORM\Column]
    private ?int $nbre_childrens = null;

    #[ORM\ManyToOne(targetEntity: Accomodation::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Accomodation $accomodation = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): static
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getNbreAdults(): ?int
    {
        return $this->nbre_adults;
    }

    public function setNbreAdults(int $nbre_adults): static
    {
        $this->nbre_adults = $nbre_adults;

        return $this;
    }

    public function getNbreChildrens(): ?int
    {
        return $this->nbre_childrens;
    }

    public function setNbreChildrens(int $nbre_childrens): static
    {
        $this->nbre_childrens = $nbre_childrens;

        return $this;
    }

    public function getAccomodation(): ?Accomodation
    {
        return $this->accomodation;
    }
    
    public function setAccomodation(?Accomodation $accomodation): static
    {
        $this->accomodation = $accomodation;
        return $this;
    }
    
    
    public function getTarification(Collection|array $tarifications): ?Tarification
    {
        // Convertir un tableau en Collection si nécessaire
        if (is_array($tarifications)) {
            $tarifications = new ArrayCollection($tarifications);
        }
    
        // Vérifier si dateStart est défini pour éviter une erreur
        if ($this->getDateStart() === null) {
            return null;
        }
    
        $month = (int) $this->getDateStart()->format('m');
        $season = match (true) {
            in_array($month, [6, 7, 8])  => 'Haute',
            in_array($month, [4, 5, 9, 10]) => 'Moyenne',
            default => 'Basse'
        };
    
        // Vérifier que la collection de tarifications n'est pas vide
        if ($tarifications->isEmpty()) {
            return null;
        }
    
        foreach ($tarifications as $tarification) {
            if ($tarification->getSeason()->getLabel() === $season) {
                return $tarification;
            }
        }
    
        return null;
    }
    
    
}
