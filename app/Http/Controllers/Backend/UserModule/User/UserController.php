<?php

namespace App\Http\Controllers\Backend\UserModule\User;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\UserModule\BuySell;
use App\Models\PriceCoverage\Prefix;
use App\Models\UserModule\Role;
use App\Models\Reports\Transaction;
use App\Models\UserModule\User;
use App\Models\UserModule\UserLocation;
use App\Models\UserModule\Validity;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //index start
    public function index(){
        if( can('all_user') ){
            return view("backend.modules.user_module.user.index");
        }else{
            return view("errors.403");
        }
    }

    //data start
    public function data(){
        if( can('all_user') ){

            if( auth('super_admin')->check() ){
                $user = User::orderBy('id', 'desc')->select("id","name","email","role_id","phone","is_active","image","staff_id","lastActive")->get();
            }
            elseif( auth('web')->check() ){
                $auth = auth('web')->user();

                $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                $user = User::orderBy('id', 'desc')->where("id","!=",$auth->id)
                ->whereHas('user_location', function ($query) use ($user_location) {
                    $query->whereIn('location_id', $user_location);
                })    
                ->select("id","name","email","role_id","phone","is_active","image","staff_id","lastActive")->get();
                
            }

            return DataTables::of($user)
            ->rawColumns(['action', 'is_active','permission','name','image','type','online'])
            ->editColumn('name', function(User $user){
                return $user->name;
            })
            ->editColumn('online', function(User $user){
                if( Carbon::now()->format("Y-m-d H:i") == Carbon::parse($user->lastActive)->format('Y-m-d H:i') ){
                    return "Online";
                }
                else{
                    return Carbon::parse($user->lastActive)->diffForHumans();
                }

            })
            ->editColumn('image', function(User $user){
                if( $user->image == null ){
                    $src = asset("images/profile/user.png");
                }
                else{
                    $src = asset("images/profile/".$user->image);
                }
                return "
                    <img src='$src' width='50px' style='border-radius: 100%'>
                ";
            })
            ->editColumn('type', function (User $user) {
                return $user->role->name;
            })
            ->editColumn('is_active', function (User $user) {
                if ($user->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (User $user) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$user->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$user->id.'">

                        '.( can("edit_user") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('user.edit',$user->id).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        ': '') .'

                    </div>
                </div>
                ';
            })
            ->make(true);
        }else{
            return unauthorized();
        }
    }


    //user add modal start
    public function add_modal(){
        if( can('add_user') ){

            if( auth('super_admin')->check() ){
                $groups = Location::where("type","Group")->select("id","name")->get();
                return view("backend.modules.user_module.user.modals.add", compact("groups"));
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                return view("backend.modules.user_module.user.modals.add", compact("auth","groups"));
            }
           

        }
        else{
            return unauthorized();
        }
    }

    //add user start
    public function add(Request $request){
        if( can('add_user') ){
            $validator = Validator::make($request->all(),[
                'staff_id' => 'required|integer',
                'role_id' => 'required|integer|exists:roles,id',
                'group_id' => 'required',
                'company_id' => 'required',
                'location_id' => 'required',
            ]);
            

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }else{
                try{

                    $user_info = UserInfo($request->staff_id);

                    if( $user_info && $user_info->status == "Active" ){

                        $user = new User();
                        $user->staff_id = $request->staff_id;                        
                        $user->name = $user_info->staffname;                        
                        $user->email  = $user_info->email ?? null;
                        $user->phone = $user_info->contactno ?? null;                        
                        $user->role_id = $request->role_id;
                        $user->is_active = true;
                        
                        if( $user->save() ){

                            if( $request->group_id && $request->company_id && $request->location_id ){

                                //group create
                                $user_location = new UserLocation();
                                $user_location->user_id = $user->id;
                                $user_location->location_id = $request->group_id;
                                $user_location->type = "Group";
                                $user_location->save();

                                //company create
                                foreach( $request->company_id as $company_id ){
                                    $user_location = new UserLocation();
                                    $user_location->user_id = $user->id;
                                    $user_location->location_id = $company_id;
                                    $user_location->type = "Company";
                                    $user_location->save();
                                }
                                
                                //location create
                                foreach( $request->location_id as $location_id ){
                                    $user_location = new UserLocation();
                                    $user_location->user_id = $user->id;
                                    $user_location->location_id = $location_id;
                                    $user_location->type = "Location";
                                    $user_location->save();
                                }
                                
                            }

                            return response()->json(['success' => 'New user created'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'Invalid user found in your staff id.'],200);
                    }

                }
                catch( Exception $e ){
                    return response()->json(['error' => $e->getMessage()],200);
                }
           }
        }else{
            return response()->json(['warning' => unauthorized()],200);
        }
    }

    //user edit modal start
    public function edit($id){
        if( can("edit_user") ){
            $user = User::where("id",$id)->with("user_location")->first();
            
            if( auth('super_admin')->check() ){
                $groups = Location::where("type","Group")->select("id","name")->get();
                return view("backend.modules.user_module.user.modals.edit", compact("user","groups"));
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();

                return view("backend.modules.user_module.user.modals.edit", compact("user","groups","auth"));
            }

            
        }
        else{
            return unauthorized();
        }
    }

    //user update modal start
    public function update(Request $request, $id){
        if( can('edit_user') ){
            
            $validator = Validator::make($request->all(),[
                'is_active' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required|numeric',
                'role_id' => 'integer',
           ]);

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }
           else{
                try{
                    $user = User::find($id);

                    if( $user ){
                        $user->is_active = $request->is_active;
                        $user->name = $request->name;
                        $user->email  = $request->email;
                        $user->phone = $request->phone;

                        if( $request->role_id ){
                            $user->role_id = $request->role_id;
                        }
    
                        if( $user->save() ){

                            if( $request->group_id && $request->company_id && $request->location_id ){
                                DB::statement("DELETE FROM user_locations WHERE user_id = $user->id");

                                //group create
                                $user_location = new UserLocation();
                                $user_location->user_id = $user->id;
                                $user_location->location_id = $request->group_id;
                                $user_location->type = "Group";
                                $user_location->save();

                                //company create
                                foreach( $request->company_id as $company_id ){
                                    $user_location = new UserLocation();
                                    $user_location->user_id = $user->id;
                                    $user_location->location_id = $company_id;
                                    $user_location->type = "Company";
                                    $user_location->save();
                                }
                                
                                //location create
                                foreach( $request->location_id as $location_id ){
                                    $user_location = new UserLocation();
                                    $user_location->user_id = $user->id;
                                    $user_location->location_id = $location_id;
                                    $user_location->type = "Location";
                                    $user_location->save();
                                }
                                
                            }

                            return response()->json(['success' => "User Updated"], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'No user found'],200);
                    }
                    
                }catch( Exception $e ){
                    return response()->json(['error' => $e->getMessage()],200);
                }
           }
        }
        else{
            return response()->json(['warning' => unauthorized()],200);
        }
    }

    
}