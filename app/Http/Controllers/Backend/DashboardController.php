<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Rockyjvec\Onvif\Onvif;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth('super_admin')->check() || auth('web')->check()) {
            return view('backend.dashboard');
        } else {
            return view("errors.404");
        }
    }


    //order_progress function start
    public function order_progress()
    {
        try {
            $month = Carbon::now()->month;
            $this_month = Carbon::now()->month - 1;
            $year = Carbon::now()->year;
            $data = [];

            for ($i = 0; $i < 6; $i++) {


                array_push(
                    $data,
                    [
                        "total_order" => 8,
                        "total_income" => 3,
                        "possible_income" => 123,
                        "time" => Carbon::create()->day(1)->month($month)->format('M') . ' ' . $year,
                    ]
                );

                $month--;

                if ($i == $this_month && $month < 6) {
                    $year = $year - 1;
                }

                if ($month == 0) {
                    $month = 12;
                }
            }

            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
    //order_progress function end



    // database_download function start
    public function database_download()
    {

        try {
            $username = "root";
            $password = "";
            $db_name = "frozen_food";
            $name = Carbon::now()->toDateString() . '.sql';
            $upload_path = public_path('database/');
            $full_path = $upload_path . $name;

            exec("mysqldump -u$username -p$password $db_name > $full_path");

            $headers = array(
                'Content-Type: application/sql',
            );

            return Response::download($full_path, $name, $headers);
        } catch (\Exception $e) {
            return back()->with('warning', $e->getMessage());
        }
    }
    // database_download function ends




}
