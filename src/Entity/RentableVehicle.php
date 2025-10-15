<?php

namespace App\Entity;

use App\Repository\RentableVehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentableVehicleRepository::class)]
class RentableVehicle extends Vehicle
{
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $dailyPrice = null;

    /**
     * @var Collection<int, Feedback>
     */
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'vehicle')]
    private Collection $feedback;

    /**
     * @var Collection<int, RentalOrder>
     */
    #[ORM\OneToMany(targetEntity: RentalOrder::class, mappedBy: 'vehicle')]
    private Collection $rentalOrders;

    public function __construct()
    {
        $this->feedback = new ArrayCollection();
        $this->rentalOrders = new ArrayCollection();
    }

    public function getDailyPrice(): ?string
    {
        return $this->dailyPrice;
    }

    public function setDailyPrice(string $dailyPrice): static
    {
        $this->dailyPrice = $dailyPrice;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): static
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback->add($feedback);
            $feedback->setVehicle($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedback->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getVehicle() === $this) {
                $feedback->setVehicle(null);
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
            $rentalOrder->setVehicle($this);
        }

        return $this;
    }

    public function removeRentalOrder(RentalOrder $rentalOrder): static
    {
        if ($this->rentalOrders->removeElement($rentalOrder)) {
            // set the owning side to null (unless already changed)
            if ($rentalOrder->getVehicle() === $this) {
                $rentalOrder->setVehicle(null);
            }
        }

        return $this;
    }
}
