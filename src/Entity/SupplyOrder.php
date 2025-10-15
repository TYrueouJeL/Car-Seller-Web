<?php

namespace App\Entity;

use App\Repository\SupplyOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplyOrderRepository::class)]
class SupplyOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'supplyOrders')]
    private ?Supplier $supplier = null;

    /**
     * @var Collection<int, SupplyOrderLine>
     */
    #[ORM\OneToMany(targetEntity: SupplyOrderLine::class, mappedBy: 'SupplyOrder')]
    private Collection $supplyOrderLines;

    public function __construct()
    {
        $this->supplyOrderLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, SupplyOrderLine>
     */
    public function getSupplyOrderLines(): Collection
    {
        return $this->supplyOrderLines;
    }

    public function addSupplyOrderLine(SupplyOrderLine $supplyOrderLine): static
    {
        if (!$this->supplyOrderLines->contains($supplyOrderLine)) {
            $this->supplyOrderLines->add($supplyOrderLine);
            $supplyOrderLine->setSupplyOrder($this);
        }

        return $this;
    }

    public function removeSupplyOrderLine(SupplyOrderLine $supplyOrderLine): static
    {
        if ($this->supplyOrderLines->removeElement($supplyOrderLine)) {
            // set the owning side to null (unless already changed)
            if ($supplyOrderLine->getSupplyOrder() === $this) {
                $supplyOrderLine->setSupplyOrder(null);
            }
        }

        return $this;
    }
}
