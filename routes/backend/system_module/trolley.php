<?php

use App\Http\Controllers\Backend\SystemModule\Trolley\TrolleyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'trolley'], function(){

    //index route
    Route::get("",[TrolleyController::class,"index"])->name("trolley.all");

    //data route
    Route::get("data",[TrolleyController::class,"data"])->name("trolley.data");

    //add
    Route::get("add-modal",[TrolleyController::class,"add_modal"])->name("trolley.add.modal");
    Route::post("add",[TrolleyController::class,"add"])->name("trolley.add");

    //edit
    Route::get("edit-modal/{id}",[TrolleyController::class,"edit_modal"])->name("trolley.edit.modal");
    Route::post("edit/{id}",[TrolleyController::class,"edit"])->name("trolley.edit");

    //download qr code
    Route::get("download-qr-code/{id}",[TrolleyController::class,"download_qr_code"])->name("trolley.download.qr.code");


});

?>