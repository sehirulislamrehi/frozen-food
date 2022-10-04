<?php

namespace App\Http\Controllers\Backend\ProductionModule\BlastFreezerEntry;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class BlastFreezerEntryController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("blast_freezer_entry") ){
                return view("backend.modules.production_module.blast_freezer_entry.index");
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
