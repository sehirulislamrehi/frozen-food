<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\ProductionModule\Freezer;
use App\Models\SystemModule\Device;
use App\Models\UserModule\Role;
use App\Models\UserModule\RoleLocation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    //group_wise_company function start
    public function group_wise_company(Request $request){
        try{

            if( auth('super_admin')->check() ){
                $companies = Location::where("type","Company")->select("id","name")->where("location_id", $request->group_id)->get();
            }
            else{
                $auth = auth('web')->user();
                $group = Location::where("id", $request->group_id)->where("type","Group")->select("id","name")->first();
                $company_ids = $group->company->pluck("id");
                $user_location = $auth->user_location->where("type","Company")->whereIn("location_id",$company_ids)->pluck("location_id");
                $companies = Location::where("type","Company")->select("id","name")->whereIn("id", $user_location)->get();
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $companies
            ], 200);
        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], 200);
        }
    }
    //group_wise_company function end


    //company_wise_location function start
    public function company_wise_location(Request $request){
        try{

            if( auth('super_admin')->check() ){
                if( $request->company_ids ){
                    $locations = Location::where("type","Location")->select("id","name")->whereIn("location_id", $request->company_ids)->where("is_active", true)->get();
                }
                else{
                    $locations = [];
                }
                
            }
            else{
                
                if( $request->company_ids ){
                    $auth = auth('web')->user();
                    $data = [];

                    $company = Location::whereIn("id", $request->company_ids)->where("type","Company")->select("id","name")->with("location")->get();

                    $location_ids = '';

                    foreach( $company as $c ){
                        foreach( $c->location->pluck("id") as $id ){
                            $location_ids .= $id . ',';
                        }
                    } 
                    
                    $all_id = [];
                    foreach( explode(",",$location_ids) as $id ){
                        if( $id ){
                            array_push($all_id,$id);
                        }
                    }

                    $user_location = $auth->user_location->where("type","Location")->whereIn("location_id",$all_id)->pluck("location_id");
                    $locations = Location::where("type","Location")->select("id","name")->whereIn("id", $user_location)->get();
                   
                }
                else{
                    $locations = [];
                }

            }
            
            return response()->json([
                'status' => 'success',
                'data' => $locations
            ], 200);
        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], 200);
        }
    }
    //company_wise_location function end


    //location_wise_device function start
    public function location_wise_device(Request $request){
        try{
            
            $device = Device::where("location_id",$request->location_id)->select("id","device_number")->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $device
            ], 200);

        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], 200);
        }
    }
    //location_wise_device function end


    //location_wise_role function start
    public function location_wise_role(Request $request){
        try{
            
            if( $request->location_ids ){
                $role = RoleLocation::whereIn("location_id",$request->location_ids)->where("type","Location")->with("role")->select("role_id")->groupBy("role_id")->get();
                
            }
            else{
                $role = [];
            }
            
            
            return response()->json([
                'status' => 'success',
                'data' => $role
            ], 200);

        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], 200);
        }
    }
    //location_wise_role function end


    //location_wise_freezer function start
    public function location_wise_freezer(Request $request){
        try{
            
            $freezer = Freezer::where("location_id",$request->location_id)->select("id","name")->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $freezer
            ], 200);

        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], 200);
        }
    }
    //location_wise_freezer function end

}
