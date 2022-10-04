<?php

namespace App\Http\Controllers\Backend\LogSheetModule\TemperatureLog;

use App\Exports\TemperatureLog;
use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Excel;

class TemperatureLogController extends Controller
{

    //index function start
    public function index(){
        try{
            if( can("temperature_log") ){

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                }
                $total_freezer = 4;

                return view("backend.modules.log_sheet_module.temperature_log.index", compact("groups","total_freezer"));
                
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


    //get_data function start
    public function get_data(Request $request){
        try{
            if( can("temperature_log") ){
                $request->validate([
                    'from_date_time' => 'required',
                    'to_date_time' => 'required',
                ]);



                if( $request->freezer_id ){
                    $from = $request->from_date_time;
                    $to = $request->to_date_time;
                    $freezer_id = $request->freezer_id;
                    $year = date('Y', strtotime($from));
                    $type = $request->type;
                    $month = date('m', strtotime($from));
                    $table_name = "temperature_" . $year . "_" . $month;
    
                    if( Schema::hasTable($table_name) ) {
                        $from = date('Y-m-d H:i:01', strtotime($request->from_date_time));
                        $to = date('Y-m-d H:i:59', strtotime($request->to_date_time));
                        $temperature = $table_name . '.temperature';
                        $date_time = $table_name . '.date_time';
                        $device_manual_id = $table_name . '.device_manual_id';
                        $total_freezer = DB::select("SELECT COUNT(id) as total_freezer FROM freezer_details WHERE freezer_id = $freezer_id")[0]->total_freezer;

                        if( $type == "All" ){
                            $temperature_logs = DB::select("SELECT freezer_details.freezer_id, freezer_details.device_manual_id, $temperature, $date_time, $device_manual_id, devices.type FROM freezer_details
                                LEFT JOIN $table_name ON freezer_details.device_manual_id = $device_manual_id
                                LEFT JOIN devices ON freezer_details.device_manual_id = devices.device_manual_id
                                WHERE freezer_details.freezer_id = $freezer_id AND $date_time BETWEEN '$from' AND '$to'
                            ");
                        }
                        else{
                            $temperature_logs = DB::select("SELECT freezer_details.freezer_id, freezer_details.device_manual_id, $temperature, $date_time, $device_manual_id, devices.type FROM freezer_details
                                LEFT JOIN $table_name ON freezer_details.device_manual_id = $device_manual_id
                                LEFT JOIN devices ON freezer_details.device_manual_id = devices.device_manual_id
                                WHERE freezer_details.freezer_id = $freezer_id AND devices.type = '$type' AND $date_time BETWEEN '$from' AND '$to' 
                            ");
                        }
                        
    
                        if( auth('super_admin')->check() ){
                            $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                        }
                        else{
                            $auth = auth('web')->user();
                            $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                            $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                        }

                        $result = array();
                        foreach( $temperature_logs as $key => $temperature_log ){
                            $key = $key + 1;
                            $result[$temperature_log->date_time][] = $temperature_log;
                        }

                        $temperature_logs = $result;

                        return view("backend.modules.log_sheet_module.temperature_log.index", compact('temperature_logs','from','to','groups','total_freezer'));
                        
            
    
                    }
                    else{
                        return back()->with('warning', "No data found in your request");
                    }
                }
                else{
                    return back()->with('warning', "Please select freezer");
                }

            }
            else{
                return back()->with('warning', unauthorized());
            }
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //get_data function end

}
