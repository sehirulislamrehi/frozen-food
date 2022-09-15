<?php

use App\Http\Controllers\Backend\LogSheetModule\TemperatureLog\TemperatureLogController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'temperature'], function(){

    //index route
    Route::get("",[TemperatureLogController::class,"index"])->name("temperature.log");

    //get temperature
    Route::get("get-data",[TemperatureLogController::class,"get_data"])->name("temperature.get.data");

});

?>