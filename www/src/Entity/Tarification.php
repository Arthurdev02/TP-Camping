<?php
 
namespace App\Entity;
 
use App\Repository\TarificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
 
#[ORM\Entity(repositoryClass: TarificationRepository::class)]
class Tarification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
 
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;
 
    #[ORM\ManyToOne(inversedBy: 'tarifications')]
    private ?Season $season = null;
 
    #[ORM\ManyToOne(inversedBy: 'tarifications')]
    private ?Accomodation $accomodation = null;
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getPrice(): ?string
    {
        return $this->price;
    }
 
    public function setPrice(string $price): static
    {
        $this->price = $price;
 
        return $this;
    }
 
    public function getSeason(): ?Season
    {
        return $this->season;
    }
 
    public function setSeason(?Season $season): static
    {
        $this->season = $season;
 
        return $this;
    }
 
    public function getAccomodations(): ?Accomodation
    {
        return $this->accomodation;
    }
 
    public function setAccomodations(?Accomodation $accomodation): static
    {
        $this->accomodation = $accomodation;
 
        return $this;
    }
}
 