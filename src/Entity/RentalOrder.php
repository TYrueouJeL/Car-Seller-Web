<?php

namespace App\Entity;

use App\Repository\RentalOrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalOrderRepository::class)]
class RentalOrder extends Order
{
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'rentalOrders')]
    private ?RentableVehicle $vehicle = null;

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getVehicle(): ?RentableVehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?RentableVehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
