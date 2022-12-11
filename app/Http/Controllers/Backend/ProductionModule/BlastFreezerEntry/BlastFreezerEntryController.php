<?php

namespace App\Http\Controllers\Backend\ProductionModule\BlastFreezerEntry;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\ProductionModule\BlastFreezerEntry;
use App\Models\SystemModule\ProductDetails;
use App\Models\SystemModule\Trolley;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlastFreezerEntryController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("blast_freezer_entry") ){

                if( auth('super_admin')->check() ){
                    $blast_freezer_entries = BlastFreezerEntry::orderBy("id","desc")
                    ->where("status","In")
                    ->with('device','trolley','product_details')
                    ->paginate(20);
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                    $blast_freezer_entries = BlastFreezerEntry::orderBy("id","desc")
                    ->where("status","In")
                    ->with('device','trolley','product_details')
                    ->whereIn("location_id",$user_location)
                    ->paginate(20);
                }

                $current_time = Carbon::parse(date('Y-m-d H:i:s', strtotime(Carbon::now())));
                $current_second = 60 - date('s', strtotime(Carbon::now()));
                $current_min = date('i', strtotime(Carbon::now()));

                return view("backend.modules.production_module.blast_freezer_entry.index", compact("blast_freezer_entries","current_time","current_second","current_min"));
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


    //out_item function start
    public function out_item(Request $request){
        try{
            if( can("blast_freezer_entry") ){

                $from = null;
                $to = null;
                $search = $request->search;

                $query = BlastFreezerEntry::orderBy("id","desc")
                ->where("status","Out")
                ->where("remaining_quantity","!=",0)
                ->with('device','trolley','product_details');

                if( $request->from_date && $request->to_date ){
                    $from = date('Y-m-d H:i:00', strtotime($request->from_date));
                    $to = date('Y-m-d H:i:00', strtotime($request->to_date));
                    $query = $query->where("lead_time",">=",$from)->where("lead_time","<=",$to);
                }

                if( $search ){

                    $query->whereHas('device', function ($device) use ($search){
                        $device->where('device_manual_id', $search);
                    })->orWhereHas('trolley', function ($trolley) use ($search){
                        $trolley->where('code', $search);
                    })->orwhere("code",$search);
                    
                }

                if( auth('super_admin')->check() ){
                    $blast_freezer_entries = $query->paginate(20);
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                    $blast_freezer_entries = $query->whereIn("location_id",$user_location)->paginate(20);
                }

                return view("backend.modules.production_module.blast_freezer_entry.out_item", compact("blast_freezer_entries","from","to","search"));

            }
            else{
                return view("errors.403");
            }
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //out_item function end


    //add_modal function start
    public function add_modal(){
        try{
            if( can("add_blast_freezer_entry") ){
                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                }

                return view("backend.modules.production_module.blast_freezer_entry.modals.add", compact("groups"));

            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }
    //add_modal function end


    //add function start
    public function add(Request $request){
        try{
            if( can("add_blast_freezer_entry") ){
                $validator = Validator::make($request->all(),[
                    'group_id' =>  'required|integer|exists:locations,id',
                    'company_id' =>  'required|integer|exists:locations,id',
                    'location_id' =>  'required|integer|exists:locations,id',
                    'device_id' =>  'required|integer|exists:devices,id',
                    'trolley_id' =>  'required|integer|exists:trolleys,id',
                    'product_details_id' =>  'required|integer|exists:product_details,id',
                    'lead_time' =>  'required',
                    'quantity' =>  'required|integer|min:1',
                    'stock_quantity' =>  'required|integer|min:1',
                ]);

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{
                    $product_details = ProductDetails::where("id",$request->product_details_id)->select("id","product_id","quantity")->with("product")->first();

                    if( $product_details->quantity > $request->quantity ){
                        $current_time = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                        $lead_time = date('Y-m-d H:i:s', strtotime($request->lead_time));

                        if( $current_time > $lead_time ){
                            return response()->json(['warning' => 'Lead time cannot be lower than current time'],200);
                        }
                        else{

                            $trolley = Trolley::where("id", $request->trolley_id)->where("status","Free")->where("is_active", true)->first();

                            if( $trolley ){

                                $blast_freezer_entries = new BlastFreezerEntry();
                                $blast_freezer_entries->code = "BF" . rand(000000,999999);

                                $blast_freezer_entries->group_id = $request->group_id;
                                $blast_freezer_entries->company_id = $request->company_id;
                                $blast_freezer_entries->location_id = $request->location_id;

                                $blast_freezer_entries->device_id = $request->device_id;
                                $blast_freezer_entries->trolley_id = $request->trolley_id;
                                $blast_freezer_entries->product_details_id  = $request->product_details_id;
                                $blast_freezer_entries->lead_time  = $lead_time;
                                $blast_freezer_entries->quantity  = $request->quantity;
                                $blast_freezer_entries->remaining_quantity  = $request->quantity;
                                $blast_freezer_entries->status  = 'In';
    
                                if( $blast_freezer_entries->save() ){

                                    $trolley->status = "Used";

                                    if( $trolley->save() ){
                                        return response()->json(['status' => 'success','location_reload' => 'New trolley inserted into the blast freeze.'],200);
                                    }

                                }
                            }
                            else{
                                return response()->json(['warning' => 'No trolley found'],200);
                            }

                        }
        
                    }
                    else{
                        return response()->json(['warning' => 'Quantity cannot be larger than the product stock.'],200);
                    }

                }
            }
            else{
                return response()->json(['warning' => unauthorized()],200);
            }
        }
        catch( Exception $e ){
            return response()->json(['error' => $e->getMessage()],200);
        }
    }
    //add function end


    //edit_modal function start
    public function edit_modal($id){
        try{

            if( can("edit_blast_freezer_entry") ){
                
                $blast_freezer_entry = BlastFreezerEntry::where("id", decrypt($id))->select("code","id","status","lead_time")->first();

                if( $blast_freezer_entry ){
                    return view("backend.modules.production_module.blast_freezer_entry.modals.edit", compact("blast_freezer_entry"));
                }
                else{
                    return "No data found";
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
    //edit_modal function end


    //edit function start
    public function edit(Request $request, $id){
        try{
            $id = decrypt($id);
            if( can("edit_blast_freezer_entry") ){
                $validator = Validator::make($request->all(),[
                    "status" => "required|in:In,Out"
                ]);

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{
                    $blast_freezer_entry = BlastFreezerEntry::where("id", $id)->first();

                    if( $blast_freezer_entry ){

                        $trolley = Trolley::where("id", $blast_freezer_entry->trolley_id)->first();

                        if( $request->status == "In" ){

                            if( $blast_freezer_entry->status == "Out" ){
                                return response()->json(['warning' => 'Trolley already outed.'],200); 
                            }

                            $trolley->status = "Used";
                            $trolley->save();
                        }

                        if( $request->status == "Out" ){

                            if( $blast_freezer_entry->status == "Out" ){
                                return response()->json(['warning' => 'Trolley already outed.'],200); 
                            }

                            $trolley->status = "Free";
                            $trolley->save();
                        }
                        
                        $blast_freezer_entry->status = $request->status;
                        $blast_freezer_entry->trolley_outed = ($request->status == "Out") ? date('Y-m-d H:i:s') : null;
                        


                        if( $blast_freezer_entry->save() ){

                            

                            return response()->json(['status' => 'success','location_reload' => 'Status updated'],200);
                        }

                    }
                    else{
                        return response()->json(['warning' => 'No data found'],200);
                    }
                }
            }
            else{
                return response()->json(['warning' => unauthorized()],200);
            }
        }
        catch( Exception $e ){
            return response()->json(['error' => $e->getMessage()],200);
        }
    }
    //edit function end


    //delete_modal function start
    public function delete_modal($id){
        try{

            if( can("delete_blast_freezer_entry") ){
                
                $blast_freezer_entry = BlastFreezerEntry::where("id", decrypt($id))->select("code","id","status","lead_time")->first();

                if( $blast_freezer_entry ){
                    return view("backend.modules.production_module.blast_freezer_entry.modals.delete", compact("blast_freezer_entry"));
                }
                else{
                    return "No data found";
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
    //delete_modal function end


    //delete function start
    public function delete(Request $request, $id){
        try{
            $id = decrypt($id);

            if( can("delete_blast_freezer_entry") ){

                $blast_freezer_entry = BlastFreezerEntry::where("id", $id)->first();

                if( $blast_freezer_entry ){

                    if( $blast_freezer_entry->status == "Out" ){
                        return response()->json(['warning' => 'You cannot delete after trolley outed from blast freezer.'],200);
                    }
                    else{
                        $trolley = Trolley::where("id", $blast_freezer_entry->trolley_id)->first();

                        $trolley->status = "Free";
                        $trolley->save();
    
                        if( $blast_freezer_entry->delete() ){
                            return response()->json(['status' => 'success','location_reload' => 'Item deleted.'],200);
                        }
                    }
                    

                }
                else{
                    return response()->json(['warning' => 'No data found'],200);
                }
                
            }
            else{
                return response()->json(['warning' => unauthorized()],200);
            }
        }
        catch( Exception $e ){
            return response()->json(['error' => $e->getMessage()],200);
        }
    }
    //delete function end
}
