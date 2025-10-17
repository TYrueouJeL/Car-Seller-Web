<?php

namespace App\Entity;

use App\Repository\VehicleFeatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleFeatureRepository::class)]
class VehicleFeature
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'vehicleFeatures')]
    private ?Vehicle $vehicle = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'vehicleFeatures')]
    private ?Feature $feature = null;

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getFeature(): ?Feature
    {
        return $this->feature;
    }

    public function setFeature(?Feature $feature): static
    {
        $this->feature = $feature;

        return $this;
    }
}
