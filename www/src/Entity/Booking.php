<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $users = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_end = null;

    #[ORM\Column]
    private ?int $nbre_adults = null;

    #[ORM\Column]
    private ?int $nbre_childrens = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Accomodation $Accomodations = null;

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

    public function getAccomodations(): ?Accomodation
    {
        return $this->Accomodations;
    }

    public function setAccomodation(?Accomodation $Accomodations): static
    {
        $this->Accomodations = $Accomodations;

        return $this;
    }
    public function getTarification(Collection $tarifications): ?Tarification
    {
        $season = 'Basse';
        $month = (int) $this->getDateStart()->format('m');

        if (in_array($month, [6, 7, 8])) {
            $season = 'Haute';
        } elseif (in_array($month, [4, 5, 9, 10])) {
            $season = 'Moyenne';
        }

        foreach ($tarifications as $tarification) {
            if ($tarification->getSeason()->getName() === $season) {
                return $tarification;
            }
        }

        return null;
    }
}
