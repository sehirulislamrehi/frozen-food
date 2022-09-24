<?php

namespace App\Http\Controllers\Backend\SystemModule\Device;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\ProductionModule\FreezerDetails;
use App\Models\SystemModule\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("device") ){
                return view("backend.modules.system_module.device.index");
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


    //data start
    public function data(){
        if( can('device') ){

            if( auth('super_admin')->check() ){
                $devices = Device::orderBy("id","desc")->with("group","company","location")->get();
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                $devices = Device::orderBy("id","desc")->with("group","company","location")
                ->whereIn("location_id",$user_location)
                ->get();
                
            }

            return DataTables::of($devices)
            ->rawColumns(['action', 'group','company','location'])
            ->editColumn('group', function (Device $devices) {
                return $devices->group->name;
            })
            ->editColumn('company', function (Device $devices) {
                return $devices->company->name;
            })
            ->editColumn('location', function (Device $devices) {
                return $devices->location->name;
            })
            ->addColumn('action', function (Device $devices) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$devices->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$devices->id.'">

                        '.( can("edit_device") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('device.edit.modal',encrypt($devices->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        ': '') .'

                        '.( can("delete_device") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('device.delete.modal',encrypt($devices->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-trash"></i>
                            Delete
                        </a>
                        ': '') .'

                    </div>
                </div>
                ';
            })
            ->addIndexColumn()
            ->make(true);
        }else{
            return unauthorized();
        }
    }
    //data end


    //add_modal function start
    public function add_modal(){
        try{
            if( can("add_device") ){

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
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
                    'group_id' =>  'required|integer|exists:locations,id',
                    'company_id' =>  'required|integer|exists:locations,id',
                    'location_id' =>  'required|integer|exists:locations,id',
                    'device_number' => 'required|unique:devices,device_number',
                    'type' => 'required|in:Blast Freeze,Pre Cooler',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                
                    $device = new Device();

                    $device->group_id = $request->group_id;
                    $device->company_id = $request->company_id;
                    $device->location_id = $request->location_id;
                    $device->device_number = $request->device_number;
                    $device_manual_id = ip() . $request->device_number;
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
                        
                    }
                    else{
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                    }

                    return view("backend.modules.system_module.device.modals.edit",compact('groups','device'));
                
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
                    'type' => 'required|in:Blast Freeze,Pre Cooler',
                ]);
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{

                    $device = Device::where("id",$id)->first();

                    if( $device ){

                        if( $request->group_id && $request->company_id && $request->location_id ){
                            $device->group_id = $request->group_id;
                            $device->company_id = $request->company_id;
                            $device->location_id = $request->location_id;
                        }
    
                        $device->device_number = $request->device_number;
                        $device_manual_id = ip() . $request->device_number;
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
