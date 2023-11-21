<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    // // The type property would take the enum AppointmentStatus class as label (Created, Confirmed, etc instead of the passed values created, confirmed, etc) for displaying purposes in lists or other UI controls (see Enums/AppointmentStatus.php)
    protected $casts = [
        'status' => AppointmentStatus::class
        //'date' => 'datetime'
    ];


    // define relationship between models: an appointment belongs to one pet
    public function pet():belongsTo
    {
        return $this->belongsTo(Pet::class);
    }

}
