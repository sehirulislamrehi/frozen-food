<?php

namespace App\Http\Controllers\Backend\ProductionModule\Freezer;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class FreezerController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("freezer") ){
                return view("backend.modules.production_module.freezer.index");
            }
            else{
                return view("errors.403");
            }
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //index function end
}
