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
use Yajra\DataTables\Facades\DataTables;

class FreezerController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("freezer") ){

                return view("backend.modules.production_module.freezer.index");
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
        if( can('freezer') ){

            if( auth('super_admin')->check() ){
                $freezers = Freezer::orderBy("id","desc")->select("id","name","group_id","company_id","location_id")
                ->with("group","company","location")->get();
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                $freezers = Freezer::orderBy("id","desc")->select("id","name","group_id","company_id","location_id")
                ->whereIn("location_id",$user_location)
                    ->with("group","company","location")->get();

            }

            return DataTables::of($freezers)
            ->rawColumns(['action', 'group','company','location'])
            ->editColumn('group', function (Freezer $freezers) {
                return $freezers->group->name;
            })
            ->editColumn('company', function (Freezer $freezers) {
                return $freezers->company->name;
            })
            ->editColumn('location', function (Freezer $freezers) {
                return $freezers->location->name;
            })
            ->addColumn('action', function (Freezer $freezers) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$freezers->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$freezers->id.'">

                        '.( can("edit_freezer") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('freezer.edit.modal',encrypt($freezers->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        ': '') .'

                        '.( can("delete_freezer") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('freezer.delete.modal',encrypt($freezers->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
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
            if( can("add_freezer") ){

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                }

                return view("backend.modules.production_module.freezer.modals.add", compact('groups'));
                
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

                $validator = Validator::make($request->all(),[
                    'group_id' =>  'required|integer|exists:locations,id',
                    'company_id' =>  'required|integer|exists:locations,id',
                    'location_id' =>  'required|integer|exists:locations,id',
                    'name' => 'required',
                    'device_ids' => 'required',
                ]);
                

                if( $validator->fails() ){
                    return response()->json(['errors' => $validator->errors()],422);
                }
                else{
                    $freezer = new Freezer();

                    $freezer->group_id = $request->group_id;
                    $freezer->company_id = $request->company_id;
                    $freezer->location_id = $request->location_id;

                    $freezer->name = $request->name;

                    if( $freezer->save() ){

                        if( $request->device_ids ){
                            $freezers = Device::whereIn("id",$request->device_ids)->select("id","device_manual_id")->get();
    
                            foreach( $request->device_ids as $key => $device_id ){
                                $freezer_details = new FreezerDetails();
                                $freezer_details->freezer_id = $freezer->id;
                                $freezer_details->device_id = $device_id;
                                $freezer_details->device_manual_id = $freezers[$key]['device_manual_id'];
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
                    }
                    else{
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                    }

                    return view("backend.modules.production_module.freezer.modals.edit", compact('groups','freezer'));
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

                        if( $request->group_id && $request->company_id && $request->location_id ){
                            $freezer->group_id = $request->group_id;
                            $freezer->company_id = $request->company_id;
                            $freezer->location_id = $request->location_id;
                        }
                        
                        $freezer->name = $request->name;
    
                        if( $freezer->save() ){
    
                            if( $request->device_ids ){

                                DB::statement("DELETE FROM freezer_details WHERE freezer_id = $freezer->id");

                                $freezers = Device::whereIn("id",$request->device_ids)->select("id","device_manual_id")->get();
        
                                foreach( $request->device_ids as $key => $device_id ){
                                    $freezer_details = new FreezerDetails();
                                    $freezer_details->freezer_id = $freezer->id;
                                    $freezer_details->device_id = $device_id;
                                    $freezer_details->device_manual_id = $freezers[$key]['device_manual_id'];
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
