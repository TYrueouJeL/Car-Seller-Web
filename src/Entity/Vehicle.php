<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'user_vehicle' => UserVehicle::class,
    'rentable_vehicle' => RentableVehicle::class,
    'salable_vehicle' => SalableVehicle::class
])]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?model $model = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?category $category = null;

    /**
     * @var Collection<int, RentableVehicle>
     */
    #[ORM\OneToMany(targetEntity: RentableVehicle::class, mappedBy: 'vehicle')]
    private Collection $rentableVehicles;

    /**
     * @var Collection<int, SalableVehicle>
     */
    #[ORM\OneToMany(targetEntity: SalableVehicle::class, mappedBy: 'vehicle')]
    private Collection $salableVehicles;

    /**
     * @var Collection<int, UserVehicle>
     */
    #[ORM\OneToMany(targetEntity: UserVehicle::class, mappedBy: 'vehicle')]
    private Collection $userVehicles;

    public function __construct()
    {
        $this->rentableVehicles = new ArrayCollection();
        $this->salableVehicles = new ArrayCollection();
        $this->userVehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?model
    {
        return $this->model;
    }

    public function setModel(?model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, RentableVehicle>
     */
    public function getRentableVehicles(): Collection
    {
        return $this->rentableVehicles;
    }

    public function addRentableVehicle(RentableVehicle $rentableVehicle): static
    {
        if (!$this->rentableVehicles->contains($rentableVehicle)) {
            $this->rentableVehicles->add($rentableVehicle);
            $rentableVehicle->setVehicle($this);
        }

        return $this;
    }

    public function removeRentableVehicle(RentableVehicle $rentableVehicle): static
    {
        if ($this->rentableVehicles->removeElement($rentableVehicle)) {
            // set the owning side to null (unless already changed)
            if ($rentableVehicle->getVehicle() === $this) {
                $rentableVehicle->setVehicle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SalableVehicle>
     */
    public function getSalableVehicles(): Collection
    {
        return $this->salableVehicles;
    }

    public function addSalableVehicle(SalableVehicle $salableVehicle): static
    {
        if (!$this->salableVehicles->contains($salableVehicle)) {
            $this->salableVehicles->add($salableVehicle);
            $salableVehicle->setVehicle($this);
        }

        return $this;
    }

    public function removeSalableVehicle(SalableVehicle $salableVehicle): static
    {
        if ($this->salableVehicles->removeElement($salableVehicle)) {
            // set the owning side to null (unless already changed)
            if ($salableVehicle->getVehicle() === $this) {
                $salableVehicle->setVehicle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserVehicle>
     */
    public function getUserVehicles(): Collection
    {
        return $this->userVehicles;
    }

    public function addUserVehicle(UserVehicle $userVehicle): static
    {
        if (!$this->userVehicles->contains($userVehicle)) {
            $this->userVehicles->add($userVehicle);
            $userVehicle->setVehicle($this);
        }

        return $this;
    }

    public function removeUserVehicle(UserVehicle $userVehicle): static
    {
        if ($this->userVehicles->removeElement($userVehicle)) {
            // set the owning side to null (unless already changed)
            if ($userVehicle->getVehicle() === $this) {
                $userVehicle->setVehicle(null);
            }
        }

        return $this;
    }
}
