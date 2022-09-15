<?php

use App\Http\Controllers\Backend\SystemModule\Device\DeviceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'device'], function(){

    //index
    Route::get("",[DeviceController::class,"index"])->name("device.all");

    //add
    Route::get("add-modal",[DeviceController::class,"add_modal"])->name("device.add.modal");
    Route::post("add",[DeviceController::class,"add"])->name("device.add");

});

?>