<?php

namespace App\Models\SystemModule;

use App\Models\LocationModule\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trolley extends Model
{
    use HasFactory;


    public function group(){
        return $this->belongsTo(Location::class,"group_id", "id");
    }

    public function company(){
        return $this->belongsTo(Location::class,"company_id", "id");
    }

    public function location(){
        return $this->belongsTo(Location::class,"location_id", "id");
    }
    
}
