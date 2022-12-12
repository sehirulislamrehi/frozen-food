<?php

namespace App\Http\Controllers\Backend\ProductionModule\Cartoon;

use App\Http\Controllers\Controller;
use App\Models\ProductionModule\BlastFreezerEntry;
use App\Models\ProductionModule\Cartoon;
use App\Models\ProductionModule\CartoonDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartoonListController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("cartoon_list") ){

                if( auth('super_admin')->check() ){
                    $cartoons = Cartoon::orderBy("id","desc")->select("id","cartoon_name","cartoon_code","cartoon_weight","packet_quantity","status","product_id","created_at")->with("product")->paginate(20);
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                    $cartoons = Cartoon::orderBy("id","desc")->select("id","cartoon_name","cartoon_code","cartoon_weight","packet_quantity","status","product_id","created_at")->with("product")->whereIn("location_id",$user_location)->paginate(20);
                }

                return view("backend.modules.production_module.cartoon.index",compact("cartoons"));
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
                    return view("backend.modules.production_module.cartoon.edit",compact("cartoon"));
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
                    "cartoon_name" => "required|max:20",
                    "packet_quantity" => "required|integer|min:1",
                    "per_packet_weight" => "required|min:0",
                    "per_packet_item" => "required|integer|min:1"
                ]);

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{

                    if( !$request->quantity ){
                        return response()->json([
                            'warning' => 'No quantity found'
                        ],200);
                    }

                    $cartoon = Cartoon::where("cartoon_code", $code)->first();
                    if( $cartoon ){
                        if( $request->blast_freezer_entries_code ){

                            $blast_freezer_entries = BlastFreezerEntry::whereIn("code", $request->blast_freezer_entries_code)->get();
                            $cartoon_details = CartoonDetail::where("cartoon_id", $cartoon->id)->get();
                            $cartoon_weight = 0;

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
                                        if( $input_quantity == 0 ){

                                            $blast_freezer_entry->remaining_quantity += $cartoon_detail->quantity;
                                            $cartoon_detail->quantity = 0;

                                            $cartoon_detail->save();
                                            $blast_freezer_entry->save();

                                        }
                                        elseif( $input_quantity < $cartoon_detail->quantity ){
                                            $blast_freezer_entry->remaining_quantity += ( $cartoon_detail->quantity - $input_quantity ); 
                                            $cartoon_detail->quantity = $input_quantity;
                                            $cartoon_detail->save();
                                            $blast_freezer_entry->save();
                                        }
                                        elseif( $input_quantity > $cartoon_detail->quantity ){
                                            $different = $input_quantity - $cartoon_detail->quantity;

                                            if( $blast_freezer_entry->remaining_quantity >= $different ){
                                                $blast_freezer_entry->remaining_quantity -= $different; 
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
                            $cartoon->cartoon_code = "CN". rand(000000,999999);
                            $cartoon->cartoon_weight = $cartoon_weight;
                            $cartoon->packet_quantity = $request->packet_quantity;
                            $cartoon->per_packet_weight = $request->per_packet_weight;
                            $cartoon->per_packet_item = $request->per_packet_item;

                            if( $cartoon->save() ){
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
}
