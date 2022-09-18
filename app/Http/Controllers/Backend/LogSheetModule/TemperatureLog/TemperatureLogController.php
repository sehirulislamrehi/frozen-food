<?php

namespace App\Http\Controllers\Backend\LogSheetModule\TemperatureLog;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TemperatureLogController extends Controller
{

    //index function start
    public function index(){
        try{
            if( can("temperature_log") ){
                return view("backend.modules.log_sheet_module.temperature_log.index");
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

                $from = $request->from_date_time;
                $to = $request->to_date_time;

                $year = date('Y', strtotime($from));
                $month = date('m', strtotime($from));
                $table_name = "temperature_" . $year . "_" . $month;

                if( Schema::hasTable($table_name) ) {
                    $from = date('Y-m-d H:i:01', strtotime($request->from_date_time));
                    $to = date('Y-m-d H:i:59', strtotime($request->to_date_time));
                    $temperature_logs = DB::select("SELECT temperature, date_time, device_manual_id FROM $table_name 
                    WHERE date_time BETWEEN '$from' AND '$to' ");

                    return view("backend.modules.log_sheet_module.temperature_log.index", compact('temperature_logs','from','to'));

                }
                else{
                    return back()->with('warning', "No data found in your request");
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
