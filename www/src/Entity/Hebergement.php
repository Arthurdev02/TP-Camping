<?php

namespace App\Entity;

use App\Repository\HebergementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HebergementRepository::class)]
class Hebergement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $superficie = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'hebergements')]
    private ?Equipement $Equipements = null;

    #[ORM\ManyToOne(inversedBy: 'hebergements')]
    private ?Type $Types = null;

    /**
     * @var Collection<int, Tarification>
     */
    #[ORM\OneToMany(targetEntity: Tarification::class, mappedBy: 'hebergements')]
    private Collection $tarifications;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    public function __construct()
    {
        $this->tarifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getSuperficie(): ?string
    {
        return $this->superficie;
    }

    public function setSuperficie(string $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getEquipements(): ?Equipement
    {
        return $this->Equipements;
    }

    public function setEquipements(?Equipement $Equipements): static
    {
        $this->Equipements = $Equipements;

        return $this;
    }

    public function getTypes(): ?Type
    {
        return $this->Types;
    }

    public function setTypes(?Type $Types): static
    {
        $this->Types = $Types;

        return $this;
    }

    /**
     * @return Collection<int, Tarification>
     */
    public function getTarifications(): Collection
    {
        return $this->tarifications;
    }

    public function addTarification(Tarification $tarification): static
    {
        if (!$this->tarifications->contains($tarification)) {
            $this->tarifications->add($tarification);
            $tarification->setHebergements($this);
        }

        return $this;
    }

    public function removeTarification(Tarification $tarification): static
    {
        if ($this->tarifications->removeElement($tarification)) {
            // set the owning side to null (unless already changed)
            if ($tarification->getHebergements() === $this) {
                $tarification->setHebergements(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
}
