<?php

use App\Http\Controllers\Backend\LocationModule\Zipcode\ZipcodeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'zip-code'], function(){

     //index route
     Route::get("/",[ZipcodeController::class,"index"])->name('zip_code.all');

     //data route
     Route::get("data",[ZipcodeController::class,"data"])->name('zip_code.data');

     //zipcode add
    Route::get("/add",[ZipcodeController::class,'add_modal'])->name('zip_code.add.modal');
    Route::post("/add",[ZipcodeController::class,'add'])->name('zip_code.add');

    //zipcode edit
    Route::get("/edit/{id}",[ZipcodeController::class,'edit'])->name('zip_code.edit');
    Route::post("/edit/{id}",[ZipcodeController::class,'update'])->name('zip_code.update');  

    //view route
    Route::get("/view/{id}",[ZipcodeController::class,'view'])->name('zip_code.view');

});
