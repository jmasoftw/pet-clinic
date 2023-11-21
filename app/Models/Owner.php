<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

    // ------------------------------------------------------------------------------------------------------------
    // Lets define in our model the allowable properties to Mass Assignment, we use Method 3 in this app

    //  METHOD 1: (legacy) Assign each fillable property ofg our model manually
/*    public $fillable = [
      'name',
      'email',
      'phone'
    ];*/

    // METHOD 2: Open your whole model manually (Filament has safety check controls in place so we're good to do so)
/*    protected static $unguarded = true;*/

    //METHOD 3 : in the method boot() of AppServiceProvider, set Model::unguard(true); which set all of your models in the app unguarded
    //           (Again, Filament has safety check controls in place so we're good to do so)
    // ------------------------------------------------------------------------------------------------------------


    // define relationship between models: an owner can have many pets
    public function pets():HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
