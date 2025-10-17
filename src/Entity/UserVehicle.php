<?php

namespace App\Entity;

use App\Repository\UserVehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserVehicleRepository::class)]
class UserVehicle extends Vehicle
{
    #[ORM\ManyToOne(inversedBy: 'userVehicles')]
    private ?Customer $customer = null;

    /**
     * @var Collection<int, MaintenanceRequest>
     */
    #[ORM\OneToMany(targetEntity: MaintenanceRequest::class, mappedBy: 'vehicle')]
    private Collection $maintenanceRequests;

    /**
     * @var Collection<int, Maintenance>
     */
    #[ORM\OneToMany(targetEntity: Maintenance::class, mappedBy: 'vehicle')]
    private Collection $maintenances;

    public function __construct()
    {
        $this->maintenanceRequests = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

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
            $maintenanceRequest->setVehicle($this);
        }

        return $this;
    }

    public function removeMaintenanceRequest(MaintenanceRequest $maintenanceRequest): static
    {
        if ($this->maintenanceRequests->removeElement($maintenanceRequest)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceRequest->getVehicle() === $this) {
                $maintenanceRequest->setVehicle(null);
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
            $maintenance->setVehicle($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): static
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getVehicle() === $this) {
                $maintenance->setVehicle(null);
            }
        }

        return $this;
    }
}
