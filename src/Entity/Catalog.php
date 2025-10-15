<?php

namespace App\Entity;

use App\Repository\CatalogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
class Catalog
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'catalogs')]
    private ?supplier $supplier = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'catalogs')]
    private ?piece $piece = null;

    public function getSupplier(): ?supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?supplier $supplier): static
    {
        $this->supplier = $supplier;

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
