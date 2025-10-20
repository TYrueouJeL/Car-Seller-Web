<?php

namespace App\Entity;

use App\Repository\SalableVehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalableVehicleRepository::class)]
class SalableVehicle extends Vehicle
{
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    /**
     * @var Collection<int, SaleOrder>
     */
    #[ORM\OneToMany(targetEntity: SaleOrder::class, mappedBy: 'vehicle', cascade: ['remove'], orphanRemoval: true)]
    private Collection $saleOrders;

    public function __construct()
    {
        $this->saleOrders = new ArrayCollection();
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

    /**
     * @return Collection<int, SaleOrder>
     */
    public function getSaleOrders(): Collection
    {
        return $this->saleOrders;
    }

    public function addSaleOrder(SaleOrder $saleOrder): static
    {
        if (!$this->saleOrders->contains($saleOrder)) {
            $this->saleOrders->add($saleOrder);
            $saleOrder->setVehicle($this);
        }

        return $this;
    }

    public function removeSaleOrder(SaleOrder $saleOrder): static
    {
        if ($this->saleOrders->removeElement($saleOrder)) {
            // set the owning side to null (unless already changed)
            if ($saleOrder->getVehicle() === $this) {
                $saleOrder->setVehicle(null);
            }
        }

        return $this;
    }
}
