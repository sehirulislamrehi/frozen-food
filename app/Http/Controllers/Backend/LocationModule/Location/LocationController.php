<?php

namespace App\Http\Controllers\Backend\LocationModule\Location;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    
    //index function start
    public function index(){
        try{
            if( can("location") ){
                return view("backend.modules.location_module.location.index");
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
        if( can('location') ){
            
            $location = Location::where("type","Location")->select("id","name","location_id","is_active")->with("group")->get();

            return DataTables::of($location)
            ->rawColumns(['action', 'is_active','location_id'])
            ->editColumn('location_id', function (Location $location) {
                return $location->company->name;
            })
            ->editColumn('is_active', function (Location $location) {
                if ($location->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } 
                else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (Location $location) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$location->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$location->id.'">

                        '.( can("edit_location") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('location.edit.modal',encrypt($location->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
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
            if( can("add_location") ){
                $companies = Location::where("type","Company")->select("id","name")->get();

                return view("backend.modules.location_module.location.modals.add",compact('companies'));
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
            if( can('add_location') ){
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
                    $location->type  = "Location";
                    $location->name  = $request->name;
                    $location->is_active = $request->is_active;
                    
                    if( $location->save() ){
                        return response()->json(['success' => 'New location created'], 200);
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
            if( can("edit_location") ){

                $location = Location::where("id", decrypt($id))->first();

                if( $location ){
                    $companies = Location::where("type","Company")->select("id","name")->get();
                    return view("backend.modules.location_module.location.modals.edit",compact('location', 'companies'));
                }
                else{
                    return "No location found";
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
            if( can('edit_location') ){
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
                            return response()->json(['success' => 'Location updated'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'No location found'], 200);
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
