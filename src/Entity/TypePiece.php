<?php

namespace App\Entity;

use App\Repository\TypePieceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePieceRepository::class)]
class TypePiece
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'typePieces')]
    private ?piece $piece = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'typePieces')]
    private ?type $type = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getPiece(): ?piece
    {
        return $this->piece;
    }

    public function setPiece(?piece $piece): static
    {
        $this->piece = $piece;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
