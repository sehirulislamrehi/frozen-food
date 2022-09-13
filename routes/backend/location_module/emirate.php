<?php

use App\Http\Controllers\Backend\LocationModule\Emirate\EmirateController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'city'],function(){

     //index route
     Route::get("/",[EmirateController::class,"index"])->name("emirate.all"); 
    Route::get("/data",[EmirateController::class,'data'])->name('emirate.data'); 

    //emirate add
    Route::get("/add",[EmirateController::class,'add_modal'])->name('emirate.add.modal');
    Route::post("/add",[EmirateController::class,'add'])->name('emirate.add');

    //emirate edit
    Route::get("/edit/{id}",[EmirateController::class,'edit'])->name('emirate.edit');
    Route::post("/edit/{id}",[EmirateController::class,'update'])->name('emirate.update');  

    //view route
    Route::get("/view/{id}",[EmirateController::class,'view'])->name('emirate.view');

});

?>