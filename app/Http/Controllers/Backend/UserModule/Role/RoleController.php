<?php

namespace App\Http\Controllers\Backend\UserModule\Role;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\UserModule\Role;
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
                $role = Role::select("id","name","is_active","group_id","company_id","location_id")->with("group","company","location")->get();
            }
            else{
                $auth = auth('web')->user();
                $role = Role::select("id","name","is_active","group_id","company_id","location_id")
                        ->where("group_id", $auth->group_id)
                        ->where("company_id", $auth->company_id)
                        ->where("location_id", $auth->location_id)
                        ->where("id","!=",$auth->role_id)
                        ->with("group","company","location")->get();
            }
            
            return DataTables::of($role)
            ->rawColumns(['action', 'is_active','group','company','location'])
            ->editColumn('group', function (Role $role) {
                return $role->group ? $role->group->name : 'All';
            })
            ->editColumn('company', function (Role $role) {
                return $role->company ? $role->company->name : 'All';
            })
            ->editColumn('location', function (Role $role) {
                return $role->location ? $role->location->name : 'All';
            })
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
                return view("backend.modules.user_module.role.modals.add", compact('auth'));
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
                'group_id' =>  auth('super_admin')->check() ? 'required' : '',
                'company_id' =>  auth('super_admin')->check() ? 'required' : '',
                'location_id' =>  auth('super_admin')->check() ? 'required' : '',
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

                        if( auth('super_admin')->check() ){
                            $role->group_id = $request->group_id;
                            $role->company_id = ( $request->company_id == "All" ) ? null : $request->company_id;
                            $role->location_id = ( $request->location_id == "All" ) ? null : $request->location_id;
                        }
                        else{
                            $auth = auth('web')->user();
                            $role->group_id = $auth->group_id;
                            $role->company_id = $auth->company_id;
                            $role->location_id = $auth->location_id;
                        }

                        if( $role->save() ){

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
            $role = Role::where("id",$id)->first();

            if( auth('super_admin')->check() ){
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                return view("backend.modules.user_module.role.modals.edit", compact('role', 'groups'));
            }
            else{
                $auth = auth('web')->user();
                return view("backend.modules.user_module.role.modals.edit", compact('role', 'auth'));
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

                        if( auth('super_admin')->check() ){
                            if( $request->group_id && $request->company_id && $request->location_id ){
                                $role->group_id = $request->group_id;
                                $role->company_id = ( $request->company_id == "All" ) ? null : $request->company_id ;
                                $role->location_id = ( $request->location_id == "All" ) ? null : $request->location_id;
                            }
                        }
                        else{
                            $auth = auth('web')->user();
                            $role->group_id = $auth->group_id;
                            $role->company_id = $auth->company_id;
                            $role->location_id = $auth->location_id;
                        }
                        

                        if( $role->save() ){
                            DB::statement("DELETE FROM permission_role WHERE role_id = $role->id");

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