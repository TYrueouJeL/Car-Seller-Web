<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    /**
     * @var Collection<int, TypePiece>
     */
    #[ORM\OneToMany(targetEntity: TypePiece::class, mappedBy: 'piece')]
    private Collection $typePieces;

    /**
     * @var Collection<int, Catalog>
     */
    #[ORM\OneToMany(targetEntity: Catalog::class, mappedBy: 'piece')]
    private Collection $catalogs;

    /**
     * @var Collection<int, StockMovement>
     */
    #[ORM\OneToMany(targetEntity: StockMovement::class, mappedBy: 'piece')]
    private Collection $stockMovements;

    /**
     * @var Collection<int, PieceModel>
     */
    #[ORM\OneToMany(targetEntity: PieceModel::class, mappedBy: 'piece')]
    private Collection $pieceModels;

    /**
     * @var Collection<int, SupplyOrderLine>
     */
    #[ORM\OneToMany(targetEntity: SupplyOrderLine::class, mappedBy: 'piece')]
    private Collection $supplyOrderLines;

    public function __construct()
    {
        $this->typePieces = new ArrayCollection();
        $this->catalogs = new ArrayCollection();
        $this->stockMovements = new ArrayCollection();
        $this->pieceModels = new ArrayCollection();
        $this->supplyOrderLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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
     * @return Collection<int, TypePiece>
     */
    public function getTypePieces(): Collection
    {
        return $this->typePieces;
    }

    public function addTypePiece(TypePiece $typePiece): static
    {
        if (!$this->typePieces->contains($typePiece)) {
            $this->typePieces->add($typePiece);
            $typePiece->setPiece($this);
        }

        return $this;
    }

    public function removeTypePiece(TypePiece $typePiece): static
    {
        if ($this->typePieces->removeElement($typePiece)) {
            // set the owning side to null (unless already changed)
            if ($typePiece->getPiece() === $this) {
                $typePiece->setPiece(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Catalog>
     */
    public function getCatalogs(): Collection
    {
        return $this->catalogs;
    }

    public function addCatalog(Catalog $catalog): static
    {
        if (!$this->catalogs->contains($catalog)) {
            $this->catalogs->add($catalog);
            $catalog->setPiece($this);
        }

        return $this;
    }

    public function removeCatalog(Catalog $catalog): static
    {
        if ($this->catalogs->removeElement($catalog)) {
            // set the owning side to null (unless already changed)
            if ($catalog->getPiece() === $this) {
                $catalog->setPiece(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockMovement>
     */
    public function getStockMovements(): Collection
    {
        return $this->stockMovements;
    }

    public function addStockMovement(StockMovement $stockMovement): static
    {
        if (!$this->stockMovements->contains($stockMovement)) {
            $this->stockMovements->add($stockMovement);
            $stockMovement->setPiece($this);
        }

        return $this;
    }

    public function removeStockMovement(StockMovement $stockMovement): static
    {
        if ($this->stockMovements->removeElement($stockMovement)) {
            // set the owning side to null (unless already changed)
            if ($stockMovement->getPiece() === $this) {
                $stockMovement->setPiece(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PieceModel>
     */
    public function getPieceModels(): Collection
    {
        return $this->pieceModels;
    }

    public function addPieceModel(PieceModel $pieceModel): static
    {
        if (!$this->pieceModels->contains($pieceModel)) {
            $this->pieceModels->add($pieceModel);
            $pieceModel->setPiece($this);
        }

        return $this;
    }

    public function removePieceModel(PieceModel $pieceModel): static
    {
        if ($this->pieceModels->removeElement($pieceModel)) {
            // set the owning side to null (unless already changed)
            if ($pieceModel->getPiece() === $this) {
                $pieceModel->setPiece(null);
            }
        }

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
            $supplyOrderLine->setPiece($this);
        }

        return $this;
    }

    public function removeSupplyOrderLine(SupplyOrderLine $supplyOrderLine): static
    {
        if ($this->supplyOrderLines->removeElement($supplyOrderLine)) {
            // set the owning side to null (unless already changed)
            if ($supplyOrderLine->getPiece() === $this) {
                $supplyOrderLine->setPiece(null);
            }
        }

        return $this;
    }
}
