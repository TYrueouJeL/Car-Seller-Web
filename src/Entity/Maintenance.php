<?php

namespace App\Entity;

use App\Repository\MaintenanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    private ?Technician $technician = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    private ?MaintenanceStatus $maintenanceStatus = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    private ?MaintenanceRequest $maintenanceRequest = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'maintenances')]
    private ?UserVehicle $vehicle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCustomer(): ?customer
    {
        return $this->customer;
    }

    public function setCustomer(?customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTechnician(): ?technician
    {
        return $this->technician;
    }

    public function setTechnician(?technician $technician): static
    {
        $this->technician = $technician;

        return $this;
    }

    public function getMaintenanceStatus(): ?maintenancestatus
    {
        return $this->maintenanceStatus;
    }

    public function setMaintenanceStatus(?maintenancestatus $maintenanceStatus): static
    {
        $this->maintenanceStatus = $maintenanceStatus;

        return $this;
    }

    public function getMaintenanceRequest(): ?maintenanceRequest
    {
        return $this->maintenanceRequest;
    }

    public function setMaintenanceRequest(?maintenanceRequest $maintenanceRequest): static
    {
        $this->maintenanceRequest = $maintenanceRequest;

        return $this;
    }

    public function getType(): ?type
    {
        return $this->type;
    }

    public function setType(?type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getVehicle(): ?uservehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?uservehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
