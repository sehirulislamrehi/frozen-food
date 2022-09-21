<?php

namespace App\Http\Controllers\Backend\SystemModule\Device;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\ProductionModule\FreezerDetails;
use App\Models\SystemModule\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("device") ){

                if( auth('super_admin')->check() ){
                    $devices = Device::orderBy("id","desc")->with("group","company","location")->paginate(10);
                }
                else{
                    $auth = auth('web')->user();

                    if( $auth->company_id && $auth->location_id ){
                        $devices = Device::orderBy("id","desc")->with("group","company","location")
                        ->where("group_id",$auth->group_id)
                        ->where("company_id",$auth->company_id)
                        ->where("location_id",$auth->location_id)
                        ->paginate(10);
                    }
                    elseif( $auth->company_id ){
                        $devices = Device::orderBy("id","desc")->with("group","company","location")
                        ->where("group_id",$auth->group_id)
                        ->where("company_id",$auth->company_id)
                        ->paginate(10);
                    }
                    else{
                        $devices = Device::orderBy("id","desc")->with("group","company","location")
                        ->where("group_id",$auth->group_id)
                        ->paginate(10);
                    }
                }
                

                return view("backend.modules.system_module.device.index", compact('devices'));
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
            if( can("add_device") ){

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                    return view("backend.modules.system_module.device.modals.add",compact('groups'));
                }
                else{
                    $auth = auth('web')->user();

                    if( $auth->company_id == null && $auth->location_id == null ){
                        $companies = Location::where("type","Company")->select("id","name")->where("location_id", $auth->group_id)->where("is_active", true)
                        ->get();
                        return view("backend.modules.system_module.device.modals.add",compact('companies','auth'));
                    }
                    elseif( $auth->location_id == null ){
                        $locations = Location::where("type","Location")->select("id","name")->where("location_id", $auth->company_id)->get();
                        return view("backend.modules.system_module.device.modals.add",compact('locations','auth'));
                    }
                    else{
                        return view("backend.modules.system_module.device.modals.add",compact('auth'));
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
            if( can('add_device') ){

                if( auth('super_admin')->check() ){
                    $validator = Validator::make($request->all(),[
                        'group_id' =>  'required|integer|exists:locations,id',
                        'company_id' =>  'required|integer|exists:locations,id',
                        'location_id' =>  'required|integer|exists:locations,id',
                        'device_number' => 'required|unique:devices,device_number',
                        'type' => 'required|in:Blast Freeze,Pre Cooler',
                    ]);
                }
                else{
                    $auth = auth('web')->user();

                    if( $auth->company_id == null && $auth->location_id == null ){
                        $validator = Validator::make($request->all(),[
                            'company_id' =>  'required|integer|exists:locations,id',
                            'location_id' =>  'required|integer|exists:locations,id',
                            'device_number' => 'required|unique:devices,device_number',
                            'type' => 'required|in:Blast Freeze,Pre Cooler',
                        ]);
                    }
                    elseif( $auth->location_id == null ){
                        $validator = Validator::make($request->all(),[
                            'location_id' =>  'required|integer|exists:locations,id',
                            'device_number' => 'required|unique:devices,device_number',
                            'type' => 'required|in:Blast Freeze,Pre Cooler',
                        ]);
                    }
                    else{
                        $validator = Validator::make($request->all(),[
                            'device_number' => 'required|unique:devices,device_number',
                            'type' => 'required|in:Blast Freeze,Pre Cooler',
                        ]);
                    }
                }
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                
                    $device = new Device();

                    if( auth('super_admin')->check() ){
                        $device->group_id = $request->group_id;
                        $device->company_id = $request->company_id;
                        $device->location_id = $request->location_id;
                    }
                    else{
                        $auth = auth('web')->user();

                        if( $auth->company_id == null && $auth->location_id == null ){
                            $device->group_id = $auth->group_id;
                            $device->company_id = $request->company_id;
                            $device->location_id = $request->location_id;
                        }
                        elseif( $auth->location_id == null ){
                            $device->group_id = $auth->group_id;
                            $device->company_id = $auth->company_id;
                            $device->location_id = $request->location_id;
                        }
                        else{
                            $device->group_id = $auth->group_id;
                            $device->company_id = $auth->company_id;
                            $device->location_id = $auth->location_id;
                        }
                    }

                    $device->device_number = $request->device_number;

                    $device_manual_id = '10465' . $request->device_number;
                    $device->device_manual_id = $device_manual_id;
                    $device->type = $request->type;
                    
                    if( $device->save() ){
                        return response()->json(['success' => 'New device created'], 200);
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
            if( can("edit_device") ){
                $device = Device::where("id", decrypt($id))->with("group","company","location")->first();

                if( $device ){
                    if( auth('super_admin')->check() ){
                        $groups = Location::where("type","Group")->select("id","name")->get();
                        return view("backend.modules.system_module.device.modals.edit",compact('groups','device'));
                    }
                    else{
                        $auth = auth('web')->user();
    
                        if( $auth->company_id == null && $auth->location_id == null ){
                            $companies = Location::where("type","Company")->select("id","name")->where("location_id", $auth->group_id)->get();
                            return view("backend.modules.system_module.device.modals.edit",compact('companies','auth','device'));
                        }
                        elseif( $auth->location_id == null ){
                            $locations = Location::where("type","Location")->select("id","name")->where("location_id", $auth->company_id)->get();
                            return view("backend.modules.system_module.device.modals.edit",compact('locations','auth','device'));
                        }
                        else{
                            return view("backend.modules.system_module.device.modals.edit",compact('auth','device'));
                        }
                    }
                
                }
                else{
                    return "No device found";
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
    public function update(Request $request, $id){
        try{
            if( can('edit_device') ){
                $id = decrypt($id);

                $validator = Validator::make($request->all(),[
                    'device_number' => 'required|unique:devices,device_number,'. $id,
                    'device_manual_id' => 'required|unique:devices,device_manual_id,'. $id,
                    'type' => 'required|in:Blast Freeze,Pre Cooler',
                ]);
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{

                    $device = Device::where("id",$id)->first();

                    if( $device ){

                        if( auth('super_admin')->check() ){
                            if( $request->group_id && $request->company_id && $request->location_id ){
                                $device->group_id = $request->group_id;
                                $device->company_id = $request->company_id;
                                $device->location_id = $request->location_id;
                            }
                        }
                        else{
                            $auth = auth('web')->user();

                            if( $request->company_id && $request->location_id ){
                                $device->group_id = $auth->group_id;
                                $device->company_id = $request->company_id;
                                $device->location_id = $request->location_id;
                            }
                            elseif( $request->location_id ){
                                $device->group_id = $auth->group_id;
                                $device->company_id = $auth->company_id;
                                $device->location_id = $request->location_id;
                            }
                        }
    
                        $device->device_number = $request->device_number;
                        $device->device_manual_id = $request->device_manual_id;
                        $device->type = $request->type;
                        
                        if( $device->save() ){

                            $freezer_details = FreezerDetails::where("device_id", $device->id)->first();

                            if( $freezer_details ){
                                $freezer_details->device_manual_id = $device->device_manual_id;
                                $freezer_details->save();
                            }
                            

                            return response()->json(['success' => 'Device updated'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'No device found'], 200);
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
            if( can("delete_device") ){
                $device = Device::where("id", decrypt($id))->select("id","device_number")->first();

                if( $device ){
                    return view("backend.modules.system_module.device.modals.delete",compact('device'));
                }
                else{
                    return "No device found";
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
            if( can('delete_device') ){
                $id = decrypt($id);

                $device = Device::where("id",$id)->first();

                if( $device ){
                    if( $device->delete() ){
                        return response()->json(['success' => 'Device deleted'], 200);
                    }
                }
                else{
                    return response()->json(['warning' => 'No device found'], 200);
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
