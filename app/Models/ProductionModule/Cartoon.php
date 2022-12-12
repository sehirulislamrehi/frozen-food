<?php

namespace App\Models\ProductionModule;

use App\Models\SystemModule\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartoon extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function cartoon_details(){
        return $this->hasMany(CartoonDetail::class)->with('blast_freezer_entry','product_details');
    }

}
