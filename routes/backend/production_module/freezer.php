<?php

use App\Http\Controllers\Backend\ProductionModule\Freezer\FreezerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'freezer'], function(){

    //index
    Route::get("",[FreezerController::class,"index"])->name("freezer.all");

    //data
    Route::get("data",[FreezerController::class,"data"])->name("freezer.data");

    //add
    Route::get("add-modal",[FreezerController::class,"add_modal"])->name("freezer.add.modal");
    Route::post("add",[FreezerController::class,"add"])->name("freezer.add");

    //edit
    Route::get("edit-modal/{id}",[FreezerController::class,"edit_modal"])->name("freezer.edit.modal");
    Route::post("edit/{id}",[FreezerController::class,"edit"])->name("freezer.edit");
    
    //delete
    Route::get("delete-modal/{id}",[FreezerController::class,"delete_modal"])->name("freezer.delete.modal");
    Route::post("delete/{id}",[FreezerController::class,"delete"])->name("freezer.delete");

});

?>