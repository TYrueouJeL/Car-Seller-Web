<?php

namespace App\Components;

use App\Entity\Vehicle;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('detail')]
class DetailComponent
{
    public Vehicle $vehicle;
    public array $features;
    public string $type;
}
