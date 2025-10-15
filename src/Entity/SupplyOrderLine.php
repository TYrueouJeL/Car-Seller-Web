<?php

namespace App\Entity;

use App\Repository\SupplyOrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplyOrderLineRepository::class)]
class SupplyOrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'supplyOrderLines')]
    private ?piece $piece = null;

    #[ORM\ManyToOne(inversedBy: 'supplyOrderLines')]
    private ?stockMovement $stockMovement = null;

    #[ORM\ManyToOne(inversedBy: 'supplyOrderLines')]
    private ?supplyOrder $SupplyOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPiece(): ?piece
    {
        return $this->piece;
    }

    public function setPiece(?piece $piece): static
    {
        $this->piece = $piece;

        return $this;
    }

    public function getStockMovement(): ?stockMovement
    {
        return $this->stockMovement;
    }

    public function setStockMovement(?stockMovement $stockMovement): static
    {
        $this->stockMovement = $stockMovement;

        return $this;
    }

    public function getSupplyOrder(): ?supplyOrder
    {
        return $this->SupplyOrder;
    }

    public function setSupplyOrder(?supplyOrder $SupplyOrder): static
    {
        $this->SupplyOrder = $SupplyOrder;

        return $this;
    }
}
