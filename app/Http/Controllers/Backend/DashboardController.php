<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        if( auth('super_admin')->check() || auth('web')->check() ){
            
            return view('backend.dashboard');
        }
        else{
            return view("errors.404");
        }
    }


    //order_progress function start
    public function order_progress(){
        try{
            $month = Carbon::now()->month;
            $this_month = Carbon::now()->month - 1;
            $year = Carbon::now()->year;
            $data = [];

            for( $i = 0 ; $i < 6 ; $i++ ){


                array_push($data,
                    [
                        "total_order" => 8,
                        "total_income" => 3,
                        "possible_income" => 123,
                        "time" => Carbon::create()->day(1)->month($month)->format('M') .' '. $year,
                    ]
                );
                
                $month--;

                if( $i == $this_month && $month < 6 ){
                    $year = $year - 1;
                }
                
                if( $month == 0 ){
                    $month = 12;
                }
            }

            return response()->json(['data' => $data], 200);

        }
        catch( Exception $e ){
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
    //order_progress function end




}