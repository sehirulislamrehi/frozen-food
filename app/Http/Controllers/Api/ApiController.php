<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApiController extends Controller
{
    
    //store_temperature function start
    public function store_temperature(Request $request){
        try{
            $year = date('Y', strtotime(Carbon::now()));
            $month = date('m', strtotime(Carbon::now()));
            
            $table_name = "temperature_" . $year . "_" . $month;

            if( Schema::hasTable($table_name) ) {

                $data = [];
                foreach( $request['data'] as $data ){
                    array_push($data,[
                        'temperature' => $data->temperature, 
                        'date_time' => $data->date_time, 
                        'device_manual_id' => "10465". $data->device_manual_id,
                    ]);
                }

                DB::table($table_name)->insert($data);
                
            }
            else{
                Schema::connection('mysql')->create($table_name, function($table)
                {
                    $table->id();
                    $table->double("temperature");
                    $table->dateTime("date_time");
                    $table->integer("device_manual_id");
                });

                $data = [];
                foreach( $request['data'] as $data ){
                    array_push($data,[
                        'temperature' => $data->temperature, 
                        'date_time' => $data->date_time, 
                        'device_manual_id' => "10465". $data->device_manual_id,
                    ]);
                }

                DB::table($table_name)->insert($data);
            }
        }
        catch( Exception $e ){
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ],200);
        }
    }
    //store_temperature function end

}
