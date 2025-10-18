<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('card_list')]
class CardListComponent
{
    public array $items = [];
    public string $type;
    public ?string $detail_path = null;
}
