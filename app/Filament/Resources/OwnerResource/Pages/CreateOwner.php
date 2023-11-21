<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    // Once we edit this resource, go to the listing of resources (index)
    // In the create form the url can´t be null (we always redirect) so we force it to be a string
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
