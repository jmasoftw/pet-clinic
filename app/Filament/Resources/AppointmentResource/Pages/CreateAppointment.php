<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;
    // In the edit form the url can't be null (we always redirect to a route as a string)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
