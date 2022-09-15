<?php

use App\Http\Controllers\Backend\CommonController;
use Illuminate\Support\Facades\Route;

Route::get("group-wise-company",[CommonController::class,"group_wise_company"])->name("group.wise.company");
Route::get("company-wise-location",[CommonController::class,"company_wise_location"])->name("company.wise.location");

?>