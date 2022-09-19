<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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

            }
            else{
                Schema::connection('mysql')->create($table_name, function($table)
                {
                    $table->id();
                    $table->double("temperature");
                    $table->dateTime("date_time");
                    $table->integer("device_manual_id");
                });
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
