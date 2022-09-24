<?php

namespace App\Models\LocationModule;

use App\Models\UserModule\UserLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    //group to company
    public function company(){
        return $this->hasMany(Location::class, "location_id", "id");
    }

    //company to location
    public function location(){
        return $this->hasMany(Location::class, "location_id", "id");
    }

    public function user_location(){
        return $this->hasMany(UserLocation::class, "location_id", "id");
    }
}
