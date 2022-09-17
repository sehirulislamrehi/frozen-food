<?php

use App\Http\Controllers\Backend\ProductionModule\Freezer\FreezerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'freezer'], function(){

    //index
    Route::get("",[FreezerController::class,"index"])->name("freezer.all");

});

?>