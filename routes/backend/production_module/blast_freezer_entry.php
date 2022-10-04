<?php

use App\Http\Controllers\Backend\ProductionModule\BlastFreezerEntry\BlastFreezerEntryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'blast-freezer-entry'], function(){

    //index
    Route::get("",[BlastFreezerEntryController::class,"index"])->name("blast.freezer.entry.all");

});

?>