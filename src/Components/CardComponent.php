<?php

namespace App\Components;

use App\Entity\Vehicle;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('card')]
class CardComponent
{
    public Vehicle $vehicle;
    public ?string $detail_path = null;
    public string $type;
}
