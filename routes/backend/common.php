<?php

use App\Http\Controllers\Backend\CommonController;
use Illuminate\Support\Facades\Route;

Route::get("group-wise-company",[CommonController::class,"group_wise_company"])->name("group.wise.company");
Route::get("company-wise-location",[CommonController::class,"company_wise_location"])->name("company.wise.location");
Route::get("location-wise-device",[CommonController::class,"location_wise_device"])->name("location.wise.device");
Route::get("location-wise-role",[CommonController::class,"location_wise_role"])->name("location.wise.role");
Route::get("location-wise-freezer",[CommonController::class,"location_wise_freezer"])->name("location.wise.freezer");

?>