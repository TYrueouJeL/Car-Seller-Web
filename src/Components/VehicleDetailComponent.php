<?php

namespace App\Components;

use App\Entity\Vehicle;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('vehicle_detail')]
class VehicleDetailComponent
{
    public Vehicle $vehicle;
    public array $features;
    public string $type;
}
