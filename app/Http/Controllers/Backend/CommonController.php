<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\SystemModule\Device;
use Exception;
use Illuminate\Http\Request;

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
                
                if( $auth->company_id ){
                    $companies = Location::where("type","Company")->select("id","name")->where("id", $auth->company_id)->get();
                }
                else{
                    $companies = Location::where("type","Company")->select("id","name")->where("location_id", $request->group_id)->get();
                }

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
                $locations = Location::where("type","Location")->select("id","name")->where("location_id", $request->company_id)->get();
            }
            else{
                $auth = auth('web')->user();
                
                if( $auth->location_id ){
                    $locations = Location::where("type","Location")->select("id","name")->where("id", $auth->location_id)->get();
                }
                else{
                    $locations = Location::where("type","Location")->select("id","name")->where("location_id", $request->company_id)->get();
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
}
