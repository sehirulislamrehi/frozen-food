<?php

use App\Http\Controllers\Backend\ProductionModule\BlastFreezerEntry\BlastFreezerEntryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'blast-freezer-entry'], function(){

    //index
    Route::get("",[BlastFreezerEntryController::class,"index"])->name("blast.freezer.entry.all");

    //add
    Route::get("add-modal",[BlastFreezerEntryController::class,"add_modal"])->name("blast.freezer.entry.modal");
    Route::post("add",[BlastFreezerEntryController::class,"add"])->name("blast.freezer.entry");

    //edit
    Route::get("edit-modal/{id}",[BlastFreezerEntryController::class,"edit_modal"])->name("blast.freezer.entry.edit.modal");
    Route::post("edit/{id}",[BlastFreezerEntryController::class,"edit"])->name("blast.freezer.entry.edit");

    //delete
    Route::get("delete-modal/{id}",[BlastFreezerEntryController::class,"delete_modal"])->name("blast.freezer.entry.delete.modal");
    Route::post("delete/{id}",[BlastFreezerEntryController::class,"delete"])->name("blast.freezer.entry.delete");

});

?>