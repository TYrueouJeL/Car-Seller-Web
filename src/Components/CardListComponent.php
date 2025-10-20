<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('card_list')]
class CardListComponent
{
    public array $items = [];
    public string $type;
    public ?int $column_count = 3;
    public ?string $detail_path = null;
}
