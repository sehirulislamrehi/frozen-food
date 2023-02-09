<?php

namespace App\Http\Controllers\Backend\SystemModule\Trolley;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\SystemModule\Trolley;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF; 
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TrolleyController extends Controller
{

    //index function start
    public function index(){
        try{
            if( can("trolley") ){
                return view("backend.modules.system_module.trolley.index");
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


    //data start
    public function data(){
        if( can('trolley') ){

            if( auth('super_admin')->check() ){
                $trolley = Trolley::orderBy("id","desc")->select("id","code","name","company_id","location_id","status","is_active")->with("company","location")->get();
            }
            else{
                $auth = auth('web')->user();
                $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                $trolley = Trolley::orderBy("id","desc")->select("id","code","name","company_id","location_id","status","is_active")
                ->with("company","location")
                ->whereIn("location_id",$user_location)
                ->get();
            }

            return DataTables::of($trolley)
            ->rawColumns(['action','company','location','status','is_active'])
            ->editColumn('company', function (Trolley $trolley) {
                return $trolley->company->name;
            })
            ->editColumn('location', function (Trolley $trolley) {
                return $trolley->location->name;
            })
            ->editColumn('status', function (Trolley $trolley) {

                if( $trolley->status == "Free" ){
                    return "<p class='badge badge-success'>$trolley->status</p>";
                }
                else{
                    return "<p class='badge badge-danger'>$trolley->status</p>";
                }
                
            })
            ->editColumn('is_active', function (Trolley $trolley) {
                if ($trolley->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } 
                else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (Trolley $trolley) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$trolley->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$trolley->id.'">

                        '.( can("trolley") ? '
                        <a class="dropdown-item" href="'. route('trolley.download.qr.code', encrypt($trolley->id)) .'" target="_blank" class="btn btn-outline-dark">
                            <i class="fas fa-download"></i>
                            Download QR Code
                        </a>
                        ': '') .'

                        '.( can("edit_trolley") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('trolley.edit.modal',encrypt($trolley->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
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
    //data end


    //download_qr_code function start
    public function download_qr_code($id){
        try{
            if( can("trolley") ){

                $trolley = Trolley::where("id", decrypt($id))->select("code")->first();

                if( $trolley ){

                    $documentFileName = "qr-code-". $trolley->code . ".pdf";
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                    
                    $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($trolley->code));
                    $pdf = PDF::loadView('backend.modules.system_module.trolley.pdf.qrcode', compact('qrcode','trolley','xml'));
                    return $pdf->stream();

                }
                else{
                    return back()->with('warning', 'No trolley found');
                }

            }
            else{
                return view("errors.403");
            }
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //download_qr_code function end


    //add_modal function start
    public function add_modal(){
        try{
            if( can("add_trolley") ){

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


    //add function start
    public function add(Request $request){
        try{
            if( can('add_trolley') ){

                $validator = Validator::make($request->all(),[
                    'group_id' =>  'required|integer|exists:locations,id',
                    'company_id' =>  'required|integer|exists:locations,id',
                    'location_id' =>  'required|integer|exists:locations,id',
                    'name' => 'required',
                    // 'storage' => 'required|integer|min:0',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{

                    $trolley = new Trolley();

                    $trolley->code = "T" . rand(000000,999999);
                    $trolley->name = $request->name;
                    $trolley->group_id = $request->group_id;
                    $trolley->company_id = $request->company_id;
                    $trolley->location_id = $request->location_id;
                    $trolley->status = "Free";
                    // $trolley->storage = $request->storage;
                    $trolley->is_active = true;
                    
                    if( $trolley->save() ){
                        return response()->json(['success' => 'New trolley created'], 200);
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
            if( can("edit_trolley") ){

                $trolley = Trolley::where("id", decrypt($id))->with("group","company","location")->first();

                if( $trolley ){
                    if( auth('super_admin')->check() ){
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                    }
                    else{
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                    }
    
                    return view("backend.modules.system_module.trolley.modals.edit",compact('groups','trolley'));
                }
                else{
                    return "No trolley found";
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
            if( can('edit_trolley') ){
                $id = decrypt($id);
                $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    // 'storage' => 'required|integer|min:0',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{

                    $trolley = Trolley::where("id", $id)->first();

                    if( $trolley ){
                        $trolley->name = $request->name;

                        if( $request->group_id && $request->company_id && $request->location_id ){
                            $trolley->group_id = $request->group_id;
                            $trolley->company_id = $request->company_id;
                            $trolley->location_id = $request->location_id;
                        }
                        
                        // $trolley->storage = $request->storage;
                        $trolley->is_active = $request->is_active;
                        
                        if( $trolley->save() ){
                            return response()->json(['success' => 'Trolley updated'], 200);
                        }

                    }
                    else{
                        return response()->json(['warning' => 'No trolley found'], 200);
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
