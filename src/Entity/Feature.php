<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeatureRepository::class)]
class Feature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, VehicleFeature>
     */
    #[ORM\OneToMany(targetEntity: VehicleFeature::class, mappedBy: 'feature')]
    private Collection $vehicleFeatures;

    public function __construct()
    {
        $this->vehicleFeatures = new ArrayCollection();
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

    /**
     * @return Collection<int, VehicleFeature>
     */
    public function getVehicleFeatures(): Collection
    {
        return $this->vehicleFeatures;
    }

    public function addVehicleFeature(VehicleFeature $vehicleFeature): static
    {
        if (!$this->vehicleFeatures->contains($vehicleFeature)) {
            $this->vehicleFeatures->add($vehicleFeature);
            $vehicleFeature->setFeature($this);
        }

        return $this;
    }

    public function removeVehicleFeature(VehicleFeature $vehicleFeature): static
    {
        if ($this->vehicleFeatures->removeElement($vehicleFeature)) {
            // set the owning side to null (unless already changed)
            if ($vehicleFeature->getFeature() === $this) {
                $vehicleFeature->setFeature(null);
            }
        }

        return $this;
    }
}
