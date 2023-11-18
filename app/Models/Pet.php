<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

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
