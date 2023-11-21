<?php

namespace App\Models;

use App\Enums\PetType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    // The type property would take the enum PetType class as label (Dog, Cat, etc instead of the passed values dog, cat, etc) for displaying purposes in lists or other UI controls (see Enums/PetType.php)
    protected $casts = [
        'type' => PetType::class
    ];

    // define relationship between models: a pet belongs to an owner
    public function owner():BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    // define relationship between models: a pet can have many appointments
    public function appointments():HasMany
    {
        return $this->hasMany(Appointment::class);
    }

}
