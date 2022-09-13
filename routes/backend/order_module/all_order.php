<?php

use App\Http\Controllers\Backend\OrderModule\AllOrder\AllOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'all-order'], function(){

     //index
     Route::get("/",[AllOrderController::class,"index"])->name("order.all");

     //edit
     Route::get("edit-modal/{id}",[AllOrderController::class,"edit_modal"])->name("order.edit.modal");
     Route::post("edit/{id}",[AllOrderController::class,"edit"])->name("order.edit");

     //view
     Route::get("view/{id}",[AllOrderController::class,"view"])->name("order.view.modal");
});

?>