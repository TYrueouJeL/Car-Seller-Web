<?php

namespace App\Entity;

use App\Repository\MaintenanceRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRequestRepository::class)]
class MaintenanceRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $requestDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $approvedDate = null;

    #[ORM\ManyToOne(inversedBy: 'maintenanceRequests')]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'maintenanceRequests')]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'maintenanceRequests')]
    private ?UserVehicle $vehicle = null;

    #[ORM\ManyToOne(inversedBy: 'maintenanceRequests')]
    private ?Technician $technician = null;

    /**
     * @var Collection<int, Maintenance>
     */
    #[ORM\OneToMany(targetEntity: Maintenance::class, mappedBy: 'maintenanceRequest')]
    private Collection $maintenances;

    public function __construct()
    {
        $this->maintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestDate(): ?\DateTime
    {
        return $this->requestDate;
    }

    public function setRequestDate(\DateTime $requestDate): static
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    public function getApprovedDate(): ?\DateTimeImmutable
    {
        return $this->approvedDate;
    }

    public function setApprovedDate(\DateTimeImmutable $approvedDate): static
    {
        $this->approvedDate = $approvedDate;

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

    public function getTechnician(): ?technician
    {
        return $this->technician;
    }

    public function setTechnician(?technician $technician): static
    {
        $this->technician = $technician;

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
            $maintenance->setMaintenanceRequest($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): static
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getMaintenanceRequest() === $this) {
                $maintenance->setMaintenanceRequest(null);
            }
        }

        return $this;
    }
}
