<?php

namespace App\Http\Controllers\Backend\ProductionModule\BlastFreezerEntry;

use App\Http\Controllers\Controller;
use App\Models\ProductionModule\BlastFreezerEntry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartoonController extends Controller
{
    //validate_codes function start
    public function validate_codes(Request $request){
        try{
            if( can("create_cartoon") ){
                $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $request->codes)->where("remaining_quantity","!=",0)->select("code","product_details_id")->with("product_details")->get();

                if( count($blast_freezer_entries) == 0 ){
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'No trolley found in the blaste freezer'
                    ],200);
                }
                else{
                    $product_ids = [];
                    foreach( $blast_freezer_entries as $blast_freezer_entry ){
                        array_push($product_ids, $blast_freezer_entry->product_details->product_id);
                    }
    
                    if( count(array_unique($product_ids)) == 1 ){
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Redirecting to the next step...',
                            'redirect_url' => route('create.cartoon.step.one')
                        ],200);
                    }
                    else{
                        return response()->json([
                            'status' => 'warning',
                            'message' => 'Multiple product cannot store in a cartoon'
                        ],200);
                    }
                }
                
            }
            else{
                return response()->json([
                    'status' => 'warning',
                    'message' => unauthorized()
                ],200);
            }
        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ],200);
        }
    }
    //validate_codes function end


    //create_cartoon_step_one function start
    public function create_cartoon_step_one(Request $request){
        try{
            if( can("create_cartoon") ){
                $codes = explode(",",$request->codes[0]);
                $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $codes)->select("code","trolley_id","quantity","remaining_quantity","product_details_id")->with("trolley","product_details")->get();

                return view("backend.modules.production_module.blast_freezer_entry.create_cartoon", compact("blast_freezer_entries"));
            }
            else{
                return view("errors.403");
            }
        }
        catch( Exception $e ){
            return redirect()->route('blast.freezer.entry.out.item')->with('error', $e->getMessage());
        }
    }
    //create_cartoon_step_one function end
}
