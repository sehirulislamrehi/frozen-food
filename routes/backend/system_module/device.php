<?php

use App\Http\Controllers\Backend\SystemModule\Device\DeviceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'device'], function(){

    //index
    Route::get("",[DeviceController::class,"index"])->name("device.all");

    //data
    Route::get("data",[DeviceController::class,"data"])->name("device.data");

    //add
    Route::get("add-modal",[DeviceController::class,"add_modal"])->name("device.add.modal");
    Route::post("add",[DeviceController::class,"add"])->name("device.add");

    //edit
    Route::get("edit-modal/{id}",[DeviceController::class,"edit_modal"])->name("device.edit.modal");
    Route::post("edit/{id}",[DeviceController::class,"update"])->name("device.update");

    //delete
    Route::get("delete-modal/{id}",[DeviceController::class,"delete_modal"])->name("device.delete.modal");
    Route::post("delete/{id}",[DeviceController::class,"delete"])->name("device.delete");

});

?>