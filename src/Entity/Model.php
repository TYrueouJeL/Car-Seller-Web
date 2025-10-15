<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'models')]
    private ?brand $brand = null;

    /**
     * @var Collection<int, PieceModel>
     */
    #[ORM\OneToMany(targetEntity: PieceModel::class, mappedBy: 'model')]
    private Collection $pieceModels;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'model')]
    private Collection $vehicles;

    public function __construct()
    {
        $this->pieceModels = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
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

    public function getBrand(): ?brand
    {
        return $this->brand;
    }

    public function setBrand(?brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, PieceModel>
     */
    public function getPieceModels(): Collection
    {
        return $this->pieceModels;
    }

    public function addPieceModel(PieceModel $pieceModel): static
    {
        if (!$this->pieceModels->contains($pieceModel)) {
            $this->pieceModels->add($pieceModel);
            $pieceModel->setModel($this);
        }

        return $this;
    }

    public function removePieceModel(PieceModel $pieceModel): static
    {
        if ($this->pieceModels->removeElement($pieceModel)) {
            // set the owning side to null (unless already changed)
            if ($pieceModel->getModel() === $this) {
                $pieceModel->setModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setModel($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getModel() === $this) {
                $vehicle->setModel(null);
            }
        }

        return $this;
    }
}
