<?php

namespace App\Http\Controllers\Backend\SystemModule\Device;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
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

                $devices = Device::orderBy("id","desc")->with("group","company","location")->paginate(10);

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
                    $groups = Location::where("type","Group")->select("id","name")->get();
                }

                return view("backend.modules.system_module.device.modals.add",compact('groups'));
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
                $validator = Validator::make($request->all(),[
                    'group_id' => auth('super_admin')->check() ? 'required|integer|exists:locations,id' : '' ,
                    'company_id' => auth('super_admin')->check() ? 'required|integer|exists:locations,id' : '' ,
                    'location_id' => auth('super_admin')->check() ? 'required|integer|exists:locations,id' : '' ,
                    'device_id' => 'required|unique:devices,device_id'
                ]);
                
    
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

                    $device->device_id = $request->device_id;
                    
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
                    $groups = Location::where("type","Group")->select("id","name")->get();
                    return view("backend.modules.system_module.device.modals.edit",compact('device','groups'));
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


    //add function start
    public function update(Request $request, $id){
        try{
            if( can('edit_device') ){
                $id = decrypt($id);

                $validator = Validator::make($request->all(),[
                    'device_id' => 'required|unique:devices,device_id,'. $id
                ]);
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{

                    $device = Device::where("id",$id)->first();

                    if( $device ){

                        if( $request->group_id && $request->company_id && $request->location_id ){
                            if( auth('super_admin')->check() ){
                                $device->group_id = $request->group_id;
                                $device->company_id = $request->company_id;
                                $device->location_id = $request->location_id;
                            }
                        }
                        
    
                        $device->device_id = $request->device_id;
                        
                        if( $device->save() ){
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
    //add function end

}
