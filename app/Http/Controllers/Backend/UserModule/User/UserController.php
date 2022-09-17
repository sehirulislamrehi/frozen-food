<?php

namespace App\Http\Controllers\Backend\UserModule\User;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\UserModule\BuySell;
use App\Models\PriceCoverage\Prefix;
use App\Models\UserModule\Role;
use App\Models\Reports\Transaction;
use App\Models\UserModule\User;
use App\Models\UserModule\Validity;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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
                $user = User::orderBy('id', 'desc')->select("id","name","email","role_id","phone","is_active","image")->get();
            }
            elseif( auth('web')->check() ){
                $auth = auth('web')->user();

                if( $auth->company_id && $auth->location_id ){
                    $user = User::orderBy('id', 'desc')->where("id","!=",$auth->id)
                    ->where("group_id",$auth->group_id)
                    ->where("company_id",$auth->company_id)
                    ->where("location_id",$auth->location_id)
                    ->select("id","name","email","role_id","phone","is_active","image")->get();
                }
                elseif( $auth->company_id ){
                    $user = User::orderBy('id', 'desc')->where("id","!=",$auth->id)
                    ->where("group_id",$auth->group_id)
                    ->where("company_id",$auth->company_id)
                    ->select("id","name","email","role_id","phone","is_active","image")->get();
                }
                else{
                    $user = User::orderBy('id', 'desc')->where("id","!=",$auth->id)
                    ->where("group_id", $auth->group_id)
                    ->select("id","name","email","role_id","phone","is_active","image")->get();
                }
            }

            return DataTables::of($user)
            ->rawColumns(['action', 'is_active','permission','name','image','type'])
            ->editColumn('name', function(User $user){
                return $user->name;
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
                    
                        '.( can("reset_password") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('user.reset.modal',$user->id).'" data-target="#myModal" data-toggle="modal">
                            <i class="fas fa-key"></i>
                            Reset Password
                        </a>
                        ': '') .'

                        '.( can("edit_user") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('user.edit',$user->id).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit User
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

            $groups = Location::where("type","Group")->select("id","name")->get();

            return view("backend.modules.user_module.user.modals.add", compact("groups"));
        }
        else{
            return unauthorized();
        }
    }

    //add user start
    public function add(Request $request){
        if( can('add_user') ){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|unique:users,email,',
                'phone' => 'required|numeric',
                'role_id' => 'required|numeric',
                'password' => 'required|confirmed',
                'group_id' => 'required',
                'company_id' => 'required',
                'location_id' => 'required',
            ]);
            

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }else{
                try{
                    $user = new User();
                    $user->name = $request->name;
                    $user->email  = $request->email;
                    $user->phone = $request->phone;
                    $user->role_id = $request->role_id;
                    $user->password = Hash::make($request->password);
                    $user->is_active = true;
                    
                    $user->group_id = $request->group_id;
                    $user->company_id = ( $request->company_id == "All" ) ? null : $request->company_id ;
                    $user->location_id = ( $request->location_id == "All" ) ? null : $request->location_id;
                    
                    if( $user->save() ){
                        return response()->json(['success' => 'New user created'], 200);
                    }

                }catch( Exception $e ){
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
            $user = User::where("id",$id)->select("name","email","phone","role_id","is_active","id","group_id","company_id","location_id")->with("group","company","location")->first();
            $groups = Location::where("type","Group")->select("id","name")->get();

            return view("backend.modules.user_module.user.modals.edit", compact("user","groups"));
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
                'email' => 'required|unique:users,email,'. $id,
                'phone' => 'required|numeric',
                'role_id' => 'required|numeric',
           ]);

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }else{
                try{
                    $user = User::find($id);

                    if( $user ){
                        $user->is_active = $request->is_active;
                        $user->name = $request->name;
                        $user->email  = $request->email;
                        $user->phone = $request->phone;
                        $user->role_id = $request->role_id;

                        if( $request->group_id && $request->company_id && $request->location_id ){
                            if( auth('super_admin')->check() ){
                                $user->group_id = $request->group_id;
                                $user->company_id = ( $request->company_id == "All" ) ? null : $request->company_id ;
                                $user->location_id = ( $request->location_id == "All" ) ? null : $request->location_id;
                            }
                        }
    
                        if( $user->save() ){
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
        }else{
            return response()->json(['warning' => unauthorized()],200);
        }
    }

    //user reset modal start
    public function reset_modal($id){
        if( can("reset_password") ){
            $user = User::find($id);
            return view("backend.modules.user_module.user.modals.reset", compact("user"));
        }
        else{
            return unauthorized();
        }
    }

    //user reset start
    public function reset($id, Request $request){
        if( can("reset_password") ){
            $validator = Validator::make($request->all(),[
                'password' => 'required|confirmed|min:6',
           ]);

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }
           else{
               try{
                    $user = User::find($id);
                    $user->password = Hash::make($request->password);
                    if( $user->save() ){
                        return response()->json(['success' => 'Password Reset Successfully'], 200);
                    }
               }
               catch( Exception $e ){
                return response()->json(['error' => $e->getMessage()],200);
                }
           }
            
        }
        else{
            return response()->json(['warning' => unauthorized()],200);
        }
    }

    
}