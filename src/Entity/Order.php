<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'sale' => SaleOrder::class,
    'rental' => RentalOrder::class
])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Customer $customer = null;

    /**
     * @var Collection<int, SaleOrder>
     */
    #[ORM\OneToMany(targetEntity: SaleOrder::class, mappedBy: 'baseOrder')]
    private Collection $saleOrders;

    /**
     * @var Collection<int, RentalOrder>
     */
    #[ORM\OneToMany(targetEntity: RentalOrder::class, mappedBy: 'baseOrder')]
    private Collection $rentalOrders;

    public function __construct()
    {
        $this->saleOrders = new ArrayCollection();
        $this->rentalOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

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
            $saleOrder->setBaseOrder($this);
        }

        return $this;
    }

    public function removeSaleOrder(SaleOrder $saleOrder): static
    {
        if ($this->saleOrders->removeElement($saleOrder)) {
            // set the owning side to null (unless already changed)
            if ($saleOrder->getBaseOrder() === $this) {
                $saleOrder->setBaseOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RentalOrder>
     */
    public function getRentalOrders(): Collection
    {
        return $this->rentalOrders;
    }

    public function addRentalOrder(RentalOrder $rentalOrder): static
    {
        if (!$this->rentalOrders->contains($rentalOrder)) {
            $this->rentalOrders->add($rentalOrder);
            $rentalOrder->setBaseOrder($this);
        }

        return $this;
    }

    public function removeRentalOrder(RentalOrder $rentalOrder): static
    {
        if ($this->rentalOrders->removeElement($rentalOrder)) {
            // set the owning side to null (unless already changed)
            if ($rentalOrder->getBaseOrder() === $this) {
                $rentalOrder->setBaseOrder(null);
            }
        }

        return $this;
    }
}
