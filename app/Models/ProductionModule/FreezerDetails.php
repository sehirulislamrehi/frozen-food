<?php

namespace App\Models\ProductionModule;

use App\Models\SystemModule\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreezerDetails extends Model
{
    use HasFactory;

    public function device(){
        return $this->belongsTo(Device::class);
    }

}
