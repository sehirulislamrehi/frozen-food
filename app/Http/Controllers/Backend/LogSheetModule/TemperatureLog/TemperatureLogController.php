<?php

namespace App\Http\Controllers\Backend\LogSheetModule\TemperatureLog;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class TemperatureLogController extends Controller
{

    //index function start
    public function index(){
        try{
            //
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //index function end

}
