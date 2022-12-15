<?php

namespace App\Http\Controllers\Backend\ProductionModule\Cartoon;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\ProductionModule\BlastFreezerEntry;
use App\Models\ProductionModule\Cartoon;
use App\Models\ProductionModule\CartoonDetail;
use App\Models\SystemModule\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartoonListController extends Controller
{
    //index function start
    public function index(Request $request){
        try{
            if( can("cartoon_list") ){

                $search = "";
                $search_group = "";
                $company = "";
                $location = "";
                $product = "";
                $check_search = false;

                $query = Cartoon::orderBy("id","asc")
                ->select("id","cartoon_name","cartoon_code","actual_cartoon_weight","cartoon_weight","packet_quantity","status","product_id","created_at")
                ->where("status","In")
                ->with("product");

                if( $request->search ){
                    $search = $request->search;
                    $query->where("cartoon_code","LIKE","%$search%")->orWhere("cartoon_name","LIKE","%$search%");
                    $check_search = true;
                }
                if( $request->group_id ){
                    $search_group = Location::where("id",$request->group_id)->where("type","Group")->select("id","name")->first();
                    $query->where("group_id",$search_group->id);
                    $check_search = true;
                }
                if( $request->company_id ){
                    $company = Location::where("id",$request->company_id)->where("type","Company")->select("id","name")->first();
                    $query->where("company_id",$company->id);
                    $check_search = true;
                }
                if( $request->location_id ){
                    $location = Location::where("id",$request->location_id)->where("type","Location")->select("id","name")->first();
                    $query->where("location_id",$location->id);
                    $check_search = true;
                }
                if( $request->product_id ){
                    $product = Product::where("id",$request->product_id)->select("id","name")->first();
                    $query->where("product_id",$product->id);
                    $check_search = true;
                }

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                    $query->whereIn("location_id",$user_location);
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                }

                if( $check_search == true ){
                    $cartoons = $query->get();
                }
                else{
                    $cartoons = $query->paginate(20);
                }

                return view("backend.modules.production_module.cartoon.index",compact("cartoons","groups","search","search_group","company","location",
                "product","check_search"));
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


    //edit_cartoon_page function start
    public function edit_cartoon_page($code){
        try{
            if( can("edit_cartoon") ){

                if( auth('super_admin')->check() ){
                    $cartoon = Cartoon::where("cartoon_code", $code)->with("cartoon_details","product")->first();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                    $cartoon = Cartoon::where("cartoon_code", $code)->whereIn("location_id",$user_location)->with("cartoon_details","product")->first();
                }

                if( $cartoon ){
                    $product_details_id = (isset($cartoon->cartoon_details->pluck("product_details_id")[0])) ? $cartoon->cartoon_details->pluck("product_details_id")[0] : null;
                    return view("backend.modules.production_module.cartoon.edit",compact("cartoon","product_details_id"));
                }
                else{
                    return back()->with('error','No cartoon found');
                }

            }
            else{
                return view("errors.403");
            }
        }   
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //edit_cartoon_page function end


    //edit_cartoon function start
    public function edit_cartoon(Request $request, $code){
        try{
            if( can("edit_cartoon") ){
                $validator = Validator::make($request->all(),[
                    "cartoon_name" => "required|max:50",
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


                    $cartoon = Cartoon::where("cartoon_code", $code)->first();
                    if( $cartoon ){
                        if( $request->blast_freezer_entries_code || $request->new_blast_freezer_entries_code ){

                            if( $request->blast_freezer_entries_code ){
                                $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $request->blast_freezer_entries_code)->with("trolley","product_details")->get();
                            }
                            $cartoon_details = CartoonDetail::where("cartoon_id", $cartoon->id)->get();
                            $cartoon_weight = 0;
                            $type = "";

                            foreach( $cartoon_details as $key => $cartoon_detail ){
                                if( $request->quantity[$key] < 0 ){
                                    return response()->json([
                                        'warning' => 'Minimum value for quantity is 0.'
                                    ],200);
                                }
                                else{
                                    if( $cartoon_detail->quantity != $request->quantity[$key] ){

                                        $blast_freezer_entry = $blast_freezer_entries->where("id",$cartoon_detail->blast_freezer_entries_id)->first();
                                        $input_quantity = $request->quantity[$key];
                                        $type = $blast_freezer_entry->product_details->product->type;

                                        if( $input_quantity == 0 ){
                                            $blast_freezer_entry->remaining_quantity += number_format($cartoon_detail->quantity,2);
                                            $cartoon_detail->quantity = 0;
                                            $cartoon_detail->delete();
                                            $blast_freezer_entry->save();
                                        }
                                        elseif( $input_quantity < $cartoon_detail->quantity ){
                                            $blast_freezer_entry->remaining_quantity += number_format(( $cartoon_detail->quantity - $input_quantity ),2); 
                                            $cartoon_detail->quantity = $input_quantity;
                                            $cartoon_detail->save();
                                            $blast_freezer_entry->save();
                                        }
                                        elseif( $input_quantity > $cartoon_detail->quantity ){
                                            $different = number_format($input_quantity - $cartoon_detail->quantity,2);

                                            if( $blast_freezer_entry->remaining_quantity >= $different ){
                                                $blast_freezer_entry->remaining_quantity -= number_format($different,2); 
                                                $cartoon_detail->quantity = $input_quantity;
                                                $cartoon_detail->save();
                                                $blast_freezer_entry->save();
                                            }
                                            else{
                                                return response()->json([
                                                    'warning' => $input_quantity. ' kg cannot be stored because of enough storage.'
                                                ],200);
                                            }
                                        }
                                    }
                                }
                                
                                $cartoon_weight += $cartoon_detail->quantity;
                            }


                            $cartoon->cartoon_name = $request->cartoon_name;
                            $cartoon->cartoon_weight = $cartoon_weight;
                            $cartoon->actual_cartoon_weight = $request->cartoon_weight;
                            $cartoon->packet_quantity = $request->packet_quantity;
                            $cartoon->per_packet_weight = $request->per_packet_weight;
                            $cartoon->per_packet_item = $request->per_packet_item ?? null;
                            $cartoon->sample_item = $request->sample_item;
                            $cartoon->manufacture_date = $request->manufacture_date;
                        
                            $explode = explode("-", $request->manufacture_date);
        
                            if( $type == "Local" ){
                                $cartoon->expiry_date = $explode[0] + product_life_time("Local") .'-'. $explode[1] .'-'. $explode[2];
                            }

                            if( $type == "Export" ){
                                $cartoon->expiry_date = $explode[0] + product_life_time("Export") .'-'. $explode[1] .'-'. $explode[2];
                            }

                            if( $cartoon->save() ){

                                //new trolley entry code start
                                if( $request->new_blast_freezer_entries_code ){
                                    $new_blast_freezer_entries = BlastFreezerEntry::whereIn("code", $request->new_blast_freezer_entries_code)->select("id","code","trolley_id","quantity","remaining_quantity","product_details_id","group_id","company_id","location_id")->with("trolley","product_details")->get();
                                    $product_ids = [];
                                    foreach( $new_blast_freezer_entries as $key => $blast_freezer_entry ){

                                        $type = $blast_freezer_entry->product_details->product->type;
                
                                        array_push($product_ids, $blast_freezer_entry->product_details->product_id);
                
                                        // if( $blast_freezer_entry->product_details->product->type == "Local" ){
                                            if( $request->new_quantity[$key] < 1 ){
                                                return response()->json([
                                                    'warning' => 'Quantity must be larger than 0'
                                                ],200);
                                            }
                
                                            if( $request->new_quantity[$key] > $blast_freezer_entry->remaining_quantity ){
                                                return response()->json([
                                                    'warning' => 'Stock unavaiable in the trolley: '. $blast_freezer_entry->trolley->code
                                                ],200);
                                            }
                                            $cartoon_weight += $request->new_quantity[$key];
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

                                    $cartoon->cartoon_weight = $cartoon_weight;

                                    if( $cartoon->save() ){
                                        $cartoon_details = array();

                                        foreach( $new_blast_freezer_entries as $key => $blast_freezer_entry ){

                                            $blast_freezer_entry_remaining = BlastFreezerEntry::where("id",$blast_freezer_entry->id)->with("product_details")->first();
                                            $remaining_quantity = $blast_freezer_entry_remaining->remaining_quantity;

                                            // if( $blast_freezer_entry->product_details->product->type == "Local" ){
                                                if( $blast_freezer_entry_remaining ){
                                                    $blast_freezer_entry_remaining->remaining_quantity -= $request->new_quantity[$key];
                                                    $blast_freezer_entry_remaining->save();
                                                }
                
                                                array_push($cartoon_details,[
                                                    'cartoon_id' => $cartoon->id,
                                                    'blast_freezer_entries_id' => $blast_freezer_entry->id,
                                                    'product_details_id' => $blast_freezer_entry->product_details_id,
                                                    'quantity' => $request->new_quantity[$key],
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
                                    }

                                }
                                //new trolley entry code end

                                return response()->json([
                                    'status' => 'success',
                                    'message' => 'Cartoon updated',
                                    'redirect' => route('edit.cartoon.page', $cartoon->cartoon_code)
                                ],200);
                            }

                        }
                        else{
                            return response()->json([
                                'warning' => 'No trolley found in the blast freezer.'
                            ],200);
                        }
                    }
                    else{
                        return response()->json([
                            'warning' => 'Invalid cartoon.'
                        ],200);
                    }

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
    //edit_cartoon function end


    //add_trolley_product_cartoon_modal function start
    public function add_trolley_product_cartoon_modal($code, $product_details_id){
        try{
            if( can("create_cartoon") ){
                $cartoon = Cartoon::where("cartoon_code", $code)->with("cartoon_details")->first();

                if( $cartoon ){

                    $blast_freezer_entries_id  = $cartoon->cartoon_details->pluck("blast_freezer_entries_id");
                    
                    $query = BlastFreezerEntry::orderBy("id","desc")
                    ->where("status","Out")
                    ->where("remaining_quantity","!=",0)
                    ->with('device','trolley','product_details')
                    ->select("code","device_id","product_details_id","quantity","remaining_quantity","trolley_id","created_at","status","lead_time","trolley_outed");

                    if( $product_details_id != "null" ){
                        $query->where("product_details_id",$product_details_id);
                    }

                    if( count($blast_freezer_entries_id ) != 0 ){
                        $query->whereNotIn("id",$blast_freezer_entries_id );
                    }

                    if( auth('super_admin')->check() ){
                        $blast_freezer_entries = $query->get();
                    }
                    else{
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                        $blast_freezer_entries = $query->whereIn("location_id",$user_location)->get();
                    }

                    return view("backend.modules.production_module.cartoon.modals.add_trolley_product",compact("cartoon","blast_freezer_entries"));

                }
                else{
                    return "Invalid cartoon found";
                }

            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }
    //add_trolley_product_cartoon_modal function end


    //add_trolley_cartoon_validate function start
    public function add_trolley_cartoon_validate(Request $request){
        try{
            if( can("create_cartoon") ){

                $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $request->codes)->select("code","trolley_id","quantity","remaining_quantity","product_details_id")->with("trolley","product_details")->where("remaining_quantity","!=",0)->get();

                if( count($blast_freezer_entries) == 0 ){
                    return response()->json([
                        'status' => 'warning',
                        'data' => 'No trolley found in the blaste freezer'
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
                            'data' => $blast_freezer_entries
                        ],200);
                    }
                    else{
                        return response()->json([
                            'status' => 'warning',
                            'data' => 'Multiple product cannot store in a cartoon'
                        ],200);
                    }
                }
                
            }
            else{
                return response()->json([
                    'status' => 'warning',
                    'data' => unauthorized()
                ],200);
            }
        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ],200);
        }
    }
    //add_trolley_cartoon_validate function end
}
