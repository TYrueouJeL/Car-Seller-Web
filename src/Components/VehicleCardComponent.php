<?php

namespace App\Components;

use App\Entity\Vehicle;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('vehicle_card')]
class VehicleCardComponent
{
    public Vehicle $vehicle;
    public ?string $detail_path = null;
    public string $type;
}
