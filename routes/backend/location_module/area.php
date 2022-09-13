<?php

use App\Http\Controllers\Backend\LocationModule\Area\AreaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'area'],function(){

     //index route
     Route::get("/",[AreaController::class,"index"])->name("area.all"); 
    Route::get("data/{zone_id}",[AreaController::class,'data'])->name('area.data'); 

    //area add
    Route::get("/add",[AreaController::class,'add_modal'])->name('area.add.modal');
    Route::post("/add",[AreaController::class,'add'])->name('area.add');

    //area edit
    Route::get("/edit/{id}",[AreaController::class,'edit'])->name('area.edit');
    Route::post("/edit/{id}",[AreaController::class,'update'])->name('area.update');  

    //view route
    Route::get("/view/{id}",[AreaController::class,'view'])->name('area.view');

});

?>