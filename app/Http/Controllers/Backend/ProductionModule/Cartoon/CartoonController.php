<?php

namespace App\Http\Controllers\Backend\ProductionModule\Cartoon;

use App\Http\Controllers\Controller;
use App\Models\ProductionModule\BlastFreezerEntry;
use App\Models\ProductionModule\Cartoon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $codes)->select("code","trolley_id","quantity","remaining_quantity","product_details_id")->with("trolley","product_details")->where("remaining_quantity","!=",0)->get();

                if( count($blast_freezer_entries) != 0 ){
                    return view("backend.modules.production_module.blast_freezer_entry.create_cartoon", compact("blast_freezer_entries"));
                }
                else{
                    return redirect()->route('blast.freezer.entry.out.item')->with('error','No trolley found in the blast freezer');
                }

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


    //create_cartoon function start
    public function create_cartoon(Request $request){
        try{
            if( can("create_cartoon") ){
                $validator = Validator::make($request->all(),[
                    "cartoon_name" => "required|max:20",
                    "cartoon_weight" => "required|min:1",
                    "packet_quantity" => "required|integer|min:1",
                    "per_packet_weight" => "required|min:0",
                    "sample_item" => "required|integer|min:0",
                    "manufacture_date" => "required",
                    "expiry_date" => "required",
                ]);

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{

                    $product_ids = [];
                    $cartoon_weight = 0;
                    $group_id = 0;
                    $company_id = 0;
                    $location_id = 0;
                    $type = "";
                    
                    if( $request->blast_freezer_entries_code ){
                        $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $request->blast_freezer_entries_code)->select("id","code","trolley_id","quantity","remaining_quantity","product_details_id","group_id","company_id","location_id")->with("trolley","product_details")->get();
                    }
                    else{
                        return response()->json([
                            'warning' => 'No trolley found in the blast freezer.'
                        ],200);
                    }

                    //quantity validation start
                    foreach( $blast_freezer_entries as $key => $blast_freezer_entry ){

                        $type = $blast_freezer_entry->product_details->product->type;

                        if( $key == 0 ){
                            $group_id = $blast_freezer_entry->group_id;
                            $company_id = $blast_freezer_entry->company_id;
                            $location_id = $blast_freezer_entry->location_id;
                        }
                        array_push($product_ids, $blast_freezer_entry->product_details->product_id);

                        // if( $blast_freezer_entry->product_details->product->type == "Local" ){
                            if( $request->remaining_quantity[$key] < 1 ){
                                return response()->json([
                                    'warning' => 'Quantity must be larger than 0'
                                ],200);
                            }

                            if( $request->remaining_quantity[$key] > $blast_freezer_entry->remaining_quantity ){
                                return response()->json([
                                    'warning' => 'Stock unavaiable in the trolley: '. $blast_freezer_entry->trolley->code
                                ],200);
                            }
                            $cartoon_weight += $request->remaining_quantity[$key];
                        // }
                        // else{
                        //     if( $blast_freezer_entry->remaining_quantity < 1 ){
                        //         return response()->json([
                        //             'warning' => 'Stock unavaiable in the trolley: '. $blast_freezer_entry->trolley->code
                        //         ],200);
                        //     }
                        //     $cartoon_weight += $blast_freezer_entry->remaining_quantity;
                        // }
                        
                    }
                    //quantity validation end

                    //unique product validation start
                    if( count(array_unique($product_ids)) == 0 ){
                        return response()->json([
                            'warning' => 'No trolley found in the blast freezer.'
                        ],200);
                    }
                    elseif( count(array_unique($product_ids)) == 1 ){
                        $cartoon = new Cartoon();

                        $cartoon->cartoon_name = $request->cartoon_name;
                        $cartoon->cartoon_code = "CN". rand(000000,999999);
                        $cartoon->actual_cartoon_weight = $request->cartoon_weight;
                        $cartoon->cartoon_weight = $cartoon_weight;
                        $cartoon->packet_quantity = $request->packet_quantity;
                        $cartoon->per_packet_weight = $request->per_packet_weight;
                        $cartoon->per_packet_item = $request->per_packet_item ?? null;
                        $cartoon->sample_item = $request->sample_item;
                        $cartoon->status = "In";
                        $cartoon->product_id = $product_ids[0];
                        $cartoon->manufacture_date = $request->manufacture_date;
                        
                        $explode = explode("-", $request->manufacture_date);
    
                        if( $type == "Local" ){
                            $cartoon->expiry_date = $explode[0] + product_life_time("Local") .'-'. $explode[1] .'-'. $explode[2];
                        }

                        if( $type == "Export" ){
                            $cartoon->expiry_date = $explode[0] + product_life_time("Export") .'-'. $explode[1] .'-'. $explode[2];
                        }

                        $cartoon->group_id = $group_id;
                        $cartoon->company_id = $company_id;
                        $cartoon->location_id = $location_id;

                        if( $cartoon->save() ){

                            $cartoon_details = array();

                            foreach( $blast_freezer_entries as $key => $blast_freezer_entry ){

                                $blast_freezer_entry_remaining = BlastFreezerEntry::where("id",$blast_freezer_entry->id)->with("product_details")->first();
                                $remaining_quantity = $blast_freezer_entry_remaining->remaining_quantity;

                                // if( $blast_freezer_entry->product_details->product->type == "Local" ){
                                    if( $blast_freezer_entry_remaining ){
                                        $blast_freezer_entry_remaining->remaining_quantity -= $request->remaining_quantity[$key];
                                        $blast_freezer_entry_remaining->save();
                                    }
    
                                    array_push($cartoon_details,[
                                        'cartoon_id' => $cartoon->id,
                                        'blast_freezer_entries_id' => $blast_freezer_entry->id,
                                        'product_details_id' => $blast_freezer_entry->product_details_id,
                                        'quantity' => $request->remaining_quantity[$key],
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ]);
                                // }
                                // else{
                                //     if( $blast_freezer_entry_remaining ){
                                //         $blast_freezer_entry_remaining->remaining_quantity = 0;
                                //         $blast_freezer_entry_remaining->save();
                                //     }
    
                                //     array_push($cartoon_details,[
                                //         'cartoon_id' => $cartoon->id,
                                //         'blast_freezer_entries_id' => $blast_freezer_entry->id,
                                //         'product_details_id' => $blast_freezer_entry->product_details_id,
                                //         'quantity' => $remaining_quantity,
                                //         'created_at' => Carbon::now(),
                                //         'updated_at' => Carbon::now(),
                                //     ]);
                                // }
                                
                            }
    
                            DB::table("cartoon_details")->insert($cartoon_details);

                            return response()->json([
                                'status' => 'success',
                                'message' => 'Cartoon created',
                                'redirect' => route('edit.cartoon.page', $cartoon->cartoon_code)
                            ],200);

                        }

                    }
                    else{
                        return response()->json([
                            'warning' => 'Multiple product cannot store in a cartoon'
                        ],200);
                    }
                    //unique product validation start
                    
                }
            }
            else{
                return response()->json([
                    'warning' => unauthorized()
                ],200);
            }
        }
        catch( Exception $e ){
            return response()->json([
                'error' => $e->getMessage()
            ],200);
        }
    }
    //create_cartoon function end
}
