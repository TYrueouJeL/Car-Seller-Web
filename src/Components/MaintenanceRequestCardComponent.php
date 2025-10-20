<?php

namespace App\Components;

use App\Entity\MaintenanceRequest;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('vehicle_card')]
class MaintenanceRequestCardComponent
{
    public MaintenanceRequest $maintenanceRequest;
    public ?string $detail_path = null;
}
