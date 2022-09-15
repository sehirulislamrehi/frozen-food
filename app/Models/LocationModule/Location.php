<?php

namespace App\Models\LocationModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo(Location::class, "location_id", "id");
    }

    public function company(){
        return $this->belongsTo(Location::class, "location_id", "id");
    }
}
