<?php

namespace App\Entity;

use App\Repository\StockMovementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockMovementRepository::class)]
class StockMovement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTime $movementDate = null;

    #[ORM\ManyToOne(inversedBy: 'stockMovements')]
    private ?piece $piece = null;

    #[ORM\ManyToOne(inversedBy: 'stockMovements')]
    private ?movementType $movementType = null;

    /**
     * @var Collection<int, SupplyOrderLine>
     */
    #[ORM\OneToMany(targetEntity: SupplyOrderLine::class, mappedBy: 'stockMovement')]
    private Collection $supplyOrderLines;

    public function __construct()
    {
        $this->supplyOrderLines = new ArrayCollection();
    }

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

    public function getMovementDate(): ?\DateTime
    {
        return $this->movementDate;
    }

    public function setMovementDate(\DateTime $movementDate): static
    {
        $this->movementDate = $movementDate;

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

    public function getMovementType(): ?movementType
    {
        return $this->movementType;
    }

    public function setMovementType(?movementType $movementType): static
    {
        $this->movementType = $movementType;

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
            $supplyOrderLine->setStockMovement($this);
        }

        return $this;
    }

    public function removeSupplyOrderLine(SupplyOrderLine $supplyOrderLine): static
    {
        if ($this->supplyOrderLines->removeElement($supplyOrderLine)) {
            // set the owning side to null (unless already changed)
            if ($supplyOrderLine->getStockMovement() === $this) {
                $supplyOrderLine->setStockMovement(null);
            }
        }

        return $this;
    }
}
