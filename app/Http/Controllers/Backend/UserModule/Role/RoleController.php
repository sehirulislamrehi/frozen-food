<?php

namespace App\Http\Controllers\Backend\UserModule\Role;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\UserModule\Role;
use App\Models\UserModule\RoleLocation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    //index start
    public function index(){
        if( can('roles') ){
            return view("backend.modules.user_module.role.index");
        }else{
            return view("errors.403");
        }
    }

    //data
    public function data(){
        if( can('roles') ){

            if( auth('super_admin')->check() ){
                $role = Role::select("id","name","is_active")->get();
            }
            else{

                $auth = auth('web')->user();

                $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                $role = Role::orderBy('id', 'desc')->where("id","!=",$auth->role_id)
                ->whereHas('role_location', function ($query) use ($user_location) {
                    $query->whereIn('location_id', $user_location);
                })    
                ->select("id","name","is_active")->get();
            }
            
            return DataTables::of($role)
            ->rawColumns(['action', 'is_active'])
            ->editColumn('is_active', function (Role $role) {
                if ($role->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (Role $role) {
                return '
                '.( can("edit_roles") ? '
                <button type="button" data-content="'.route('role.edit',$role->id).'" data-target="#largeModal" class="btn btn-outline-dark" data-toggle="modal">
                    Edit
                </button>
                ': '') .'

                ';
            })
            ->make(true);
        }else{
            return unauthorized();
        }
        
    }

    //add modal
    public function add_modal(){
        if( can("add_roles") ){

            if( auth('super_admin')->check() ){
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                return view("backend.modules.user_module.role.modals.add", compact("groups"));
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();

                return view("backend.modules.user_module.role.modals.add", compact('groups'));
            }

        }
        else{
            return unauthorized();
        }
    }

    //add start
    public function add(Request $request){
        if( can('add_roles') ){

            
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|exists:locations,id',
                'company_id' => 'required|exists:locations,id',
                'location_id' => 'required|exists:locations,id',
                'name' => 'required',
            ]);
    
            if( $validator->fails() ){
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                try{
                    if( $request['permission'] ){
                        $role = new Role();
                        $role->name = $request->name;
                        $role->is_active = true;

                        if( $role->save() ){


                            if( $request->group_id && $request->company_id && $request->location_id ){

                                //group create  
                                $role_location = new RoleLocation();
                                $role_location->role_id = $role->id;
                                $role_location->location_id = $request->group_id;
                                $role_location->type = "Group";
                                $role_location->save();

                                //company create
                                foreach( $request->company_id as $company_id ){
                                    $role_location = new RoleLocation();
                                    $role_location->role_id = $role->id;
                                    $role_location->location_id = $company_id;
                                    $role_location->type = "Company";
                                    $role_location->save();
                                }
                                
                                //location create
                                foreach( $request->location_id as $location_id ){
                                    $role_location = new RoleLocation();
                                    $role_location->role_id = $role->id;
                                    $role_location->location_id = $location_id;
                                    $role_location->type = "Location";
                                    $role_location->save();
                                }
                            }

                            $data = [];
                            foreach( $request['permission'] as $permission ){
                                array_push($data,[
                                    'role_id' => $role->id, 
                                    'permission_id' => $permission, 
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }

                            DB::table('permission_role')->insert($data);
                            return response()->json(['success' => 'New Role Added Successfully'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'Please choose user permission.'],200);
                    }
                }
                catch(Exception $e){
                    return response()->json(['error' => $e->getMessage()], 200);
                }
            }
        }else{
            return response()->json(['warning' => unauthorized()], 200);
        }
        
    }

    //role edit modal
    public function edit($id){
        if( can('edit_roles') ){
            $role = Role::where("id",$id)->with("role_location")->first();

            if( auth('super_admin')->check() ){
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                return view("backend.modules.user_module.role.modals.edit", compact('role', 'groups'));
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();

                return view("backend.modules.user_module.role.modals.edit", compact('role', 'groups'));
            }

            
        }else{
            return unauthorized();
        }
        
    }

    //update start
    public function update(Request $request, $id){
        if( can('edit_roles') ){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name,'. $id,
            ]);
    
            if( $validator->fails() ){
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                try{
                    if( $request['permission'] ){
                        $role = Role::find($id);
                        $role->name = $request->name;
                        $role->is_active = $request->is_active;

                        if( $role->save() ){

                            if( $request->group_id && $request->company_id && $request->location_id ){
                                DB::statement("DELETE FROM role_locations WHERE role_id = $role->id");

                                //group create
                                $role_location = new RoleLocation();
                                $role_location->role_id = $role->id;
                                $role_location->location_id = $request->group_id;
                                $role_location->type = "Group";
                                $role_location->save();

                                //company create
                                foreach( $request->company_id as $company_id ){
                                    $role_location = new RoleLocation();
                                    $role_location->role_id = $role->id;
                                    $role_location->location_id = $company_id;
                                    $role_location->type = "Company";
                                    $role_location->save();
                                }
                                
                                //location create
                                foreach( $request->location_id as $location_id ){
                                    $role_location = new RoleLocation();
                                    $role_location->role_id = $role->id;
                                    $role_location->location_id = $location_id;
                                    $role_location->type = "Location";
                                    $role_location->save();
                                }
                                
                            }

                            $data = [];
                            foreach( $request['permission'] as $permission ){
                                array_push($data,[
                                    'role_id' => $role->id, 
                                    'permission_id' => $permission, 
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }

                            DB::statement("DELETE FROM permission_role WHERE role_id = $role->id");
                            DB::table('permission_role')->insert($data);

                            return response()->json(['success' => 'Role Updated Successfully'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'Please choose user permission.'],200);
                    }
                }
                catch(Exception $e){
                    return response()->json(['error' => $e->getMessage()], 200);
                }
            }
        }
        else{
            return response()->json(['warning' => unauthorized()], 200);
        }
    }
}