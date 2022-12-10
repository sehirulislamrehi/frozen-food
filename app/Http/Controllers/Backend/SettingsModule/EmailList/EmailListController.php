<?php

namespace App\Http\Controllers\Backend\SettingsModule\EmailList;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\SettingsModule\EmailList;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmailListController extends Controller
{

    //index function start
    public function index(){
        try{
            if( can("email_list") ){
                return view("backend.modules.setting_module.email_list.index");
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
            
            if( auth('super_admin')->check() ){
                $email_lists = EmailList::select("id","position","email","designation","is_active")->get();
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                $email_lists = Location::where("type","Location")->select("id","name","location_id","is_active")->whereIn("location_id", $user_location)->with("location_company")->get();
            }

            return DataTables::of($email_lists)
            ->rawColumns(['action', 'is_active'])
            ->editColumn('is_active', function (EmailList $email_lists) {
                if ($email_lists->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } 
                else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (EmailList $email_lists) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$email_lists->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$email_lists->id.'">

                        '.( can("edit_email_list") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('location.edit.modal',encrypt($email_lists->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
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
            if( can("add_email_list") ){

                return "Under Development...";

                if( auth('super_admin')->check() ){
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                }
                else{
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                    $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                }

                return view("backend.modules.system_module.trolley.modals.add",compact('groups'));
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

}
