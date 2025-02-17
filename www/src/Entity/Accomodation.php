<?php

namespace App\Entity;

use App\Repository\AccomodationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccomodationRepository::class)]
class Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nbreBedrooms = null;

    #[ORM\Column]
    private ?bool $isAvaliable = true;   
    
    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\ManyToMany(targetEntity: Equipement::class, inversedBy: 'accomodations')]
    private Collection $Equipements;

    #[ORM\ManyToOne(inversedBy: 'accomodations')]
    private ?Tarification $tarifications = null;

    #[ORM\ManyToOne(inversedBy: 'accomodations')]
    private ?Type $types = null;


    #[ORM\Column]
    private ?int $size = null;


    public function __construct()
    {
        $this->Equipements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->Equipements;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->Equipements->contains($equipement)) {
            $this->Equipements->add($equipement);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        $this->Equipements->removeElement($equipement);

        return $this;
    }

    public function getTarifications(): ?Tarification
    {
        return $this->tarifications;
    }

    public function setTarifications(?Tarification $tarifications): static
    {
        $this->tarifications = $tarifications;

        return $this;
    }

    public function getTypes(): ?Type
    {
        return $this->types;
    }

    public function setTypes(?Type $types): static
    {
        $this->types = $types;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getNbreBedrooms(): ?int
    {
        return $this->nbreBedrooms;
    }

    public function setNbreBedrooms(int $nbreBedrooms): static
    {
        $this->nbreBedrooms = $nbreBedrooms;

        return $this;
    }

    public function getTypeAccomodation(): ?Type
    {
        return $this->type_accomodation;
    }
 
    public function setTypeAccomodation(?Type $type_accomodation): static
    {
        $this->type_accomodation = $type_accomodation;
 
        return $this;
    }
 

    /**
     * Get the value of isAvaliable
     */
    public function isAvaliable(): ?bool
    {
        return $this->isAvaliable;
    }
    
    public function setIsAvaliable(?bool $isAvaliable): self 
   {
        $this->isAvaliable = $isAvaliable;
        return $this;
    }

    /**
     * Get the value of isAvaliable
     */
    public function getIsAvaliable(): ?bool
    {
        return $this->isAvaliable;
    }
}
