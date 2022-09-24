<?php

namespace App\Models\UserModule;

use App\Models\LocationModule\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    public function location(){
        return $this->belongsTo(Location::class);
    }

}
