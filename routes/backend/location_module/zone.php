<?php

use App\Http\Controllers\Backend\LocationModule\Zone\ZoneController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'zone'],function(){

     //index route
     Route::get("/",[ZoneController::class,"index"])->name("zone.all"); 
    Route::get("/data",[ZoneController::class,'data'])->name('zone.data'); 

    //zone add
    Route::get("/add",[ZoneController::class,'add_modal'])->name('zone.add.modal');
    Route::post("/add",[ZoneController::class,'add'])->name('zone.add');

    //zone edit
    Route::get("/edit/{id}",[ZoneController::class,'edit'])->name('zone.edit');
    Route::post("/edit/{id}",[ZoneController::class,'update'])->name('zone.update');  

    //view route
    Route::get("/view/{id}",[ZoneController::class,'view'])->name('zone.view');

});

?>