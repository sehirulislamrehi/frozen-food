<?php

namespace App\Models\ProductionModule;

use App\Models\SystemModule\Device;
use App\Models\SystemModule\ProductDetails;
use App\Models\SystemModule\Trolley;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastFreezerEntry extends Model
{
    use HasFactory;

    public function device(){
        return $this->belongsTo(Device::class);
    }

    public function trolley(){
        return $this->belongsTo(Trolley::class);
    }

    public function product_details(){
        return $this->belongsTo(ProductDetails::class)->with('product');
    }

}
