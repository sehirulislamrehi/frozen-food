<?php

use App\Http\Controllers\Backend\ProductionModule\Cartoon\CartoonController;
use App\Http\Controllers\Backend\ProductionModule\Cartoon\CartoonListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cartoon-list'], function(){

    //index
    Route::get("",[CartoonListController::class,"index"])->name("cartoon.list.all");

    //validate code
    Route::get("valdiate-code",[CartoonController::class,"validate_codes"])->name("blast.freezser.validate.code");

    //create cartoon step one
    Route::get("create-cartoon-step-one",[CartoonController::class,"create_cartoon_step_one"])->name("create.cartoon.step.one");
    Route::post("create-cartoon",[CartoonController::class,"create_cartoon"])->name("create.cartoon");

    //edit cartoon 
    Route::get("edit-cartoon/{code}",[CartoonListController::class,"edit_cartoon_page"])->name("edit.cartoon.page");
    Route::post("edit-cartoon/{code}",[CartoonListController::class,"edit_cartoon"])->name("edit.cartoon");


});

?>