<?php

namespace App\Filament\Resources\PetResource\Pages;

use App\Filament\Resources\PetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePet extends CreateRecord
{
    protected static string $resource = PetResource::class;

    // In the edit form the url can't be null (we always redirect to a route as a string)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}


