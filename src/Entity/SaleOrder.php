<?php

namespace App\Entity;

use App\Repository\SaleOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleOrderRepository::class)]
class SaleOrder extends Order
{
    #[ORM\ManyToOne(inversedBy: 'saleOrders')]
    private ?SalableVehicle $vehicle = null;

    public function getVehicle(): ?SalableVehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?SalableVehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
