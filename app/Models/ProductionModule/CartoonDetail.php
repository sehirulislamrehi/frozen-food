<?php

namespace App\Models\ProductionModule;

use App\Models\SystemModule\ProductDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartoonDetail extends Model
{
    use HasFactory;

    public function blast_freezer_entry(){
        return $this->belongsTo(BlastFreezerEntry::class,"blast_freezer_entries_id","id")->with('trolley');
    }

    public function product_details(){
        return $this->belongsTo(ProductDetails::class);
    }

    public function cartoon(){
        return $this->belongsTo(Cartoon::class);
    }

}
