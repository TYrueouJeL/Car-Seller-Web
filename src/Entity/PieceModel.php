<?php

namespace App\Entity;

use App\Repository\PieceModelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceModelRepository::class)]
class PieceModel
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'pieceModels')]
    private ?Model $model = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'pieceModels')]
    private ?Piece $piece = null;

    public function getModel(): ?model
    {
        return $this->model;
    }

    public function setModel(?model $model): static
    {
        $this->model = $model;

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
}
