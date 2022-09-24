<?php

namespace App\Http\Controllers\Backend\LocationModule\Company;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("company") ){
                return view("backend.modules.location_module.company.index");
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


    //data function start
    public function data(){
        if( can('company') ){
            
            if( auth('super_admin')->check() ){
                $company = Location::where("type","Company")->select("id","name","location_id","is_active")->with("company_group")->get();
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Company")->pluck("location_id");
                $company = Location::where("type","Company")->select("id","name","location_id","is_active")->whereIn("id", $user_location)->with("company_group")->get();
                
            }

            return DataTables::of($company)
            ->rawColumns(['action', 'is_active','location_id'])
            ->editColumn('location_id', function (Location $company) {
                return $company->company_group->name;
            })
            ->editColumn('is_active', function (Location $company) {
                if ($company->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } 
                else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (Location $company) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$company->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$company->id.'">

                        '.( can("edit_company") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('company.edit.modal',encrypt($company->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit
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
    //data function end


    //add_modal function start
    public function add_modal(){
        try{
            if( can("add_company") ){

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                }

                return view("backend.modules.location_module.company.modals.add",compact('groups'));
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
            if( can('add_company') ){
                $validator = Validator::make($request->all(),[
                    'location_id' => 'required|integer|exists:locations,id',
                    'name' => 'required|unique:locations,name',
                    'is_active' => 'required|in:0,1',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                    $location = new Location();
                    $location->location_id = $request->location_id;
                    $location->type  = "Company";
                    $location->name  = $request->name;
                    $location->is_active = $request->is_active;
                    
                    if( $location->save() ){
                        return response()->json(['success' => 'New company created'], 200);
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
            if( can("edit_company") ){

                $company = Location::where("id", decrypt($id))->first();

                if( $company ){
                    if( auth('super_admin')->check() ){
                        $groups = Location::where("type","Group")->select("id","name")->get();
                    }
                    else{
                        $auth = auth('web')->user();
                        $groups = Location::where("type","Group")->where("id",$auth->group_id )->select("id","name")->get();
                    }
                    return view("backend.modules.location_module.company.modals.edit",compact('company', 'groups'));
                }
                else{
                    return "No company found";
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
            if( can('edit_company') ){
                $id = decrypt($id);

                $validator = Validator::make($request->all(),[
                    'location_id' => 'required|integer|exists:locations,id',
                    'name' => 'required|unique:locations,name,'. $id,
                    'is_active' => 'required|in:0,1',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                    $location = Location::where("id", $id)->first();

                    if( $location ){
                        $location->location_id = $request->location_id;
                        $location->name  = $request->name;
                        $location->is_active = $request->is_active;
                        
                        if( $location->save() ){
                            return response()->json(['success' => 'Company updated'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'No company found'], 200);
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

}
