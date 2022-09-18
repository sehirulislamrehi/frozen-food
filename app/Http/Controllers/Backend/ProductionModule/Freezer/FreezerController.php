<?php

namespace App\Http\Controllers\Backend\ProductionModule\Freezer;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\ProductionModule\Freezer;
use App\Models\ProductionModule\FreezerDetails;
use App\Models\SystemModule\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FreezerController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("freezer") ){

                if( auth('super_admin')->check() ){
                    $freezers = Freezer::orderBy("id","desc")->select("id","name","group_id","company_id","location_id")
                    ->with("group","company","location")->paginate(10);
                }
                else{
                    $auth = auth('web')->user();

                    if( $auth->company_id && $auth->location_id ){
                        $freezers = Freezer::orderBy("id","desc")->select("id","name","group_id","company_id","location_id")
                        ->where("group_id",$auth->group_id)
                        ->where("company_id",$auth->company_id)
                        ->where("location_id",$auth->location_id)
                        ->with("group","company","location")->paginate(10);
                    }
                    elseif( $auth->company_id ){
                        $freezers = Freezer::orderBy("id","desc")->select("id","name","group_id","company_id","location_id")
                        ->where("group_id",$auth->group_id)
                        ->where("company_id",$auth->company_id)
                        ->with("group","company","location")->paginate(10);
                    }
                    else{
                        $freezers = Freezer::orderBy("id","desc")->select("id","name","group_id","company_id","location_id")
                        ->where("company_id",$auth->company_id)
                        ->where("location_id",$auth->location_id)
                        ->with("group","company","location")->paginate(10);
                    }
                }

                return view("backend.modules.production_module.freezer.index", compact("freezers"));
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


    //add_modal function start
    public function add_modal(){
        try{
            if( can("add_freezer") ){

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                    return view("backend.modules.production_module.freezer.modals.add", compact('groups'));
                }
                else{
                    $auth = auth('web')->user();

                    if( $auth->company_id == null && $auth->location_id == null ){
                        $companies = Location::where("type","Company")->select("id","name")->where("location_id", $auth->group_id)->where("is_active", true)
                        ->get();
                        return view("backend.modules.production_module.freezer.modals.add", compact('companies','auth'));
                    }
                    elseif( $auth->location_id == null ){
                        $locations = Location::where("type","Location")->select("id","name")->where("location_id", $auth->company_id)->get();
                        return view("backend.modules.production_module.freezer.modals.add", compact('locations','auth'));
                    }
                    else{
                        $devices = Device::where("location_id",$auth->location_id)->select("id","device_number")->get();
                        return view("backend.modules.production_module.freezer.modals.add", compact('auth','devices'));
                    }
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
    //add_modal function end


    //add function start
    public function add(Request $request){
        try{
            if( can("add_freezer") ){

                if( auth('super_admin')->check() ){
                    $validator = Validator::make($request->all(),[
                        'group_id' =>  'required|integer|exists:locations,id',
                        'company_id' =>  'required|integer|exists:locations,id',
                        'location_id' =>  'required|integer|exists:locations,id',
                        'name' => 'required',
                        'device_ids' => 'required',
                    ]);
                }
                else{
                    $auth = auth('web')->user();

                    if( $auth->company_id == null && $auth->location_id == null ){
                        $validator = Validator::make($request->all(),[
                            'company_id' =>  'required|integer|exists:locations,id',
                            'location_id' =>  'required|integer|exists:locations,id',
                            'name' => 'required',
                            'device_ids' => 'required',
                        ]);
                    }
                    elseif( $auth->location_id == null ){
                        $validator = Validator::make($request->all(),[
                            'location_id' =>  'required|integer|exists:locations,id',
                            'name' => 'required',
                            'device_ids' => 'required',
                        ]);
                    }
                    else{
                        $validator = Validator::make($request->all(),[
                            'name' => 'required',
                            'device_ids' => 'required',
                        ]);
                    }
                }

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{
                    $freezer = new Freezer();

                    if( auth('super_admin')->check() ){
                        $freezer->group_id = $request->group_id;
                        $freezer->company_id = $request->company_id;
                        $freezer->location_id = $request->location_id;
                    }
                    else{
                        $auth = auth('web')->user();

                        if( $auth->company_id == null && $auth->location_id == null ){
                            $freezer->group_id = $auth->group_id;
                            $freezer->company_id = $request->company_id;
                            $freezer->location_id = $request->location_id;
                        }
                        elseif( $auth->location_id == null ){
                            $freezer->group_id = $auth->group_id;
                            $freezer->company_id = $auth->company_id;
                            $freezer->location_id = $request->location_id;
                        }
                        else{
                            $freezer->group_id = $auth->group_id;
                            $freezer->company_id = $auth->company_id;
                            $freezer->location_id = $auth->location_id;
                        }
                    }

                    $freezer->name = $request->name;

                    if( $freezer->save() ){

                        if( $request->device_ids ){
                            $devices = Device::whereIn("id",$request->device_ids)->select("id","device_manual_id")->get();
    
                            foreach( $request->device_ids as $key => $device_id ){
                                $freezer_details = new FreezerDetails();
                                $freezer_details->freezer_id = $freezer->id;
                                $freezer_details->device_id = $device_id;
                                $freezer_details->device_manual_id = $devices[$key]['device_manual_id'];
                                $freezer_details->save();
                            }
                        }

                        return response()->json(['success' => 'New freezer created'],200);

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
            if( can("edit_freezer") ){

                $freezer = Freezer::where("id", decrypt($id))->with("details","group","company","location")->first();

                if( $freezer ){

                    if( auth('super_admin')->check() ){
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                        return view("backend.modules.production_module.freezer.modals.edit", compact('groups','freezer'));
                    }
                    else{
                        $auth = auth('web')->user();
    
                        if( $auth->company_id == null && $auth->location_id == null ){
                            $companies = Location::where("type","Company")->select("id","name")->where("location_id", $auth->group_id)->where("is_active", true)
                            ->get();
                            return view("backend.modules.production_module.freezer.modals.edit", compact('companies','auth','freezer'));
                        }
                        elseif( $auth->location_id == null ){
                            $locations = Location::where("type","Location")->select("id","name")->where("location_id", $auth->company_id)->get();
                            return view("backend.modules.production_module.freezer.modals.edit", compact('locations','auth','freezer'));
                        }
                        else{
                            $devices = Device::where("location_id",$auth->location_id)->select("id","device_number")->get();
                            return view("backend.modules.production_module.freezer.modals.edit", compact('auth','devices','freezer'));
                        }
                    }
                }
                else{
                    return "No freezer found";
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
            if( can("edit_freezer") ){
                $id = decrypt($id);

                $validator = Validator::make($request->all(),[
                    'name' => 'required',
                ]);

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{
                    $freezer = Freezer::where("id", $id)->first();

                    if( $freezer ){

                        if( auth('super_admin')->check() ){
                            if( $request->group_id && $request->groupcompany_id_id && $request->location_id ){
                                $freezer->group_id = $request->group_id;
                                $freezer->company_id = $request->company_id;
                                $freezer->location_id = $request->location_id;
                            }
                        }
                        else{
                            $auth = auth('web')->user();

                            if( $request->company_id && $request->location_id ){
                                $freezer->group_id = $auth->group_id;
                                $freezer->company_id = $request->company_id;
                                $freezer->location_id = $request->location_id;
                            }
                            elseif( $request->location_id ){
                                $freezer->group_id = $auth->group_id;
                                $freezer->company_id = $auth->company_id;
                                $freezer->location_id = $request->location_id;
                            }
                            
                        }
                        
                        
                        $freezer->name = $request->name;
    
                        if( $freezer->save() ){
    
                            if( $request->device_ids ){

                                DB::statement("DELETE FROM freezer_details WHERE freezer_id = $freezer->id");

                                $devices = Device::whereIn("id",$request->device_ids)->select("id","device_manual_id")->get();
        
                                foreach( $request->device_ids as $key => $device_id ){
                                    $freezer_details = new FreezerDetails();
                                    $freezer_details->freezer_id = $freezer->id;
                                    $freezer_details->device_id = $device_id;
                                    $freezer_details->device_manual_id = $devices[$key]['device_manual_id'];
                                    $freezer_details->save();
                                }
                            }
    
                            return response()->json(['success' => 'Freezer updated'],200);
    
                        }
                    }
                    else{
                        return response()->json(['warning' => 'No freezer found'],200);
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
            if( can("delete_freezer") ){

                $freezer = Freezer::where("id", decrypt($id))->first();

                if( $freezer ){
                    return view("backend.modules.production_module.freezer.modals.delete", compact('freezer'));
                }
                else{
                    return "No freezer found";
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
            if( can('delete_freezer') ){

                $freezer = Freezer::where("id", decrypt($id))->first();

                if( $freezer ){
                    if( $freezer->delete() ){
                        return response()->json(['success' => 'Freezer deleted'], 200);
                    }
                }
                else{
                    return response()->json(['warning' => 'No freezer found'], 200);
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
