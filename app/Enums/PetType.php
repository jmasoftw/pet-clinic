<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

// We use this enum to pre-populate a pet select form control
enum PetType: string implements HasLabel
{
    case Dog = 'dog';
    case Cat = 'cat';
    case Rat = 'rat';
    case Lizard = 'lizard';
    case Fish = 'fish';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
