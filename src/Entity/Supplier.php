<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, SupplyOrder>
     */
    #[ORM\OneToMany(targetEntity: SupplyOrder::class, mappedBy: 'supplier')]
    private Collection $supplyOrders;

    /**
     * @var Collection<int, Catalog>
     */
    #[ORM\OneToMany(targetEntity: Catalog::class, mappedBy: 'supplier')]
    private Collection $catalogs;

    public function __construct()
    {
        $this->supplyOrders = new ArrayCollection();
        $this->catalogs = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, SupplyOrder>
     */
    public function getSupplyOrders(): Collection
    {
        return $this->supplyOrders;
    }

    public function addSupplyOrder(SupplyOrder $supplyOrder): static
    {
        if (!$this->supplyOrders->contains($supplyOrder)) {
            $this->supplyOrders->add($supplyOrder);
            $supplyOrder->setSupplier($this);
        }

        return $this;
    }

    public function removeSupplyOrder(SupplyOrder $supplyOrder): static
    {
        if ($this->supplyOrders->removeElement($supplyOrder)) {
            // set the owning side to null (unless already changed)
            if ($supplyOrder->getSupplier() === $this) {
                $supplyOrder->setSupplier(null);
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
            $catalog->setSupplier($this);
        }

        return $this;
    }

    public function removeCatalog(Catalog $catalog): static
    {
        if ($this->catalogs->removeElement($catalog)) {
            // set the owning side to null (unless already changed)
            if ($catalog->getSupplier() === $this) {
                $catalog->setSupplier(null);
            }
        }

        return $this;
    }
}
