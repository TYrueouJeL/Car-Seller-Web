<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private int $duration;

    /**
     * @var Collection<int, TypePiece>
     */
    #[ORM\OneToMany(targetEntity: TypePiece::class, mappedBy: 'type')]
    private Collection $typePieces;

    /**
     * @var Collection<int, MaintenanceRequest>
     */
    #[ORM\OneToMany(targetEntity: MaintenanceRequest::class, mappedBy: 'type')]
    private Collection $maintenanceRequests;

    /**
     * @var Collection<int, Maintenance>
     */
    #[ORM\OneToMany(targetEntity: Maintenance::class, mappedBy: 'type')]
    private Collection $maintenances;

    public function __construct()
    {
        $this->typePieces = new ArrayCollection();
        $this->maintenanceRequests = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, TypePiece>
     */
    public function getTypePieces(): Collection
    {
        return $this->typePieces;
    }

    public function addTypePiece(TypePiece $typePiece): static
    {
        if (!$this->typePieces->contains($typePiece)) {
            $this->typePieces->add($typePiece);
            $typePiece->setType($this);
        }

        return $this;
    }

    public function removeTypePiece(TypePiece $typePiece): static
    {
        if ($this->typePieces->removeElement($typePiece)) {
            // set the owning side to null (unless already changed)
            if ($typePiece->getType() === $this) {
                $typePiece->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MaintenanceRequest>
     */
    public function getMaintenanceRequests(): Collection
    {
        return $this->maintenanceRequests;
    }

    public function addMaintenanceRequest(MaintenanceRequest $maintenanceRequest): static
    {
        if (!$this->maintenanceRequests->contains($maintenanceRequest)) {
            $this->maintenanceRequests->add($maintenanceRequest);
            $maintenanceRequest->setType($this);
        }

        return $this;
    }

    public function removeMaintenanceRequest(MaintenanceRequest $maintenanceRequest): static
    {
        if ($this->maintenanceRequests->removeElement($maintenanceRequest)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceRequest->getType() === $this) {
                $maintenanceRequest->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Maintenance>
     */
    public function getMaintenances(): Collection
    {
        return $this->maintenances;
    }

    public function addMaintenance(Maintenance $maintenance): static
    {
        if (!$this->maintenances->contains($maintenance)) {
            $this->maintenances->add($maintenance);
            $maintenance->setType($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): static
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getType() === $this) {
                $maintenance->setType(null);
            }
        }

        return $this;
    }
}
