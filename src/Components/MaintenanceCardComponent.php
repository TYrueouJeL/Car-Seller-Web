<?php

namespace App\Components;

use App\Entity\Maintenance;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('vehicle_card')]
class MaintenanceCardComponent
{
    public Maintenance $maintenance;
}
