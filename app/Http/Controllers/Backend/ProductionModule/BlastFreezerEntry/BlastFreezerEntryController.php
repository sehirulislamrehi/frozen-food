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

                $datas = [
                    [
                        'hour' => 2,
                        'min' => 2,
                        'sec' => 45,
                    ],
                    [
                        'hour' => 1,
                        'min' => 3,
                        'sec' => 34,
                    ],
                    [
                        'hour' => 0,
                        'min' => 1,
                        'sec' => 13,
                    ],
                ];
                return view("backend.modules.production_module.blast_freezer_entry.index", compact("datas"));
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
