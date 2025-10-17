<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
    private ?Model $model = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Category $category = null;

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

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $registration = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $mileage = null;

    /**
     * @var Collection<int, VehicleFeature>
     */
    #[ORM\OneToMany(targetEntity: VehicleFeature::class, mappedBy: 'vehicle')]
    private Collection $vehicleFeatures;

    public function __construct()
    {
        $this->rentableVehicles = new ArrayCollection();
        $this->salableVehicles = new ArrayCollection();
        $this->userVehicles = new ArrayCollection();
        $this->vehicleFeatures = new ArrayCollection();
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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): static
    {
        $this->registration = $registration;

        return $this;
    }

    public function getMileage(): ?string
    {
        return $this->mileage;
    }

    public function setMileage(string $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * @return Collection<int, VehicleFeature>
     */
    public function getVehicleFeatures(): Collection
    {
        return $this->vehicleFeatures;
    }

    public function addVehicleFeature(VehicleFeature $vehicleFeature): static
    {
        if (!$this->vehicleFeatures->contains($vehicleFeature)) {
            $this->vehicleFeatures->add($vehicleFeature);
            $vehicleFeature->setVehicle($this);
        }

        return $this;
    }

    public function removeVehicleFeature(VehicleFeature $vehicleFeature): static
    {
        if ($this->vehicleFeatures->removeElement($vehicleFeature)) {
            // set the owning side to null (unless already changed)
            if ($vehicleFeature->getVehicle() === $this) {
                $vehicleFeature->setVehicle(null);
            }
        }

        return $this;
    }
}
