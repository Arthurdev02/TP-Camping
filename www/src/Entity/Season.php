<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_end = null;

    /**
     * @var Collection<int, Tarification>
     */
    #[ORM\OneToMany(targetEntity: Tarification::class, mappedBy: 'seasons')]
    private Collection $tarifications;

    public function __construct()
    {
        $this->tarifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

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
            $tarification->setSeasons($this);
        }

        return $this;
    }

    public function removeTarification(Tarification $tarification): static
    {
        if ($this->tarifications->removeElement($tarification)) {
            // set the owning side to null (unless already changed)
            if ($tarification->getSeasons() === $this) {
                $tarification->setSeasons(null);
            }
        }

        return $this;
    }
}
