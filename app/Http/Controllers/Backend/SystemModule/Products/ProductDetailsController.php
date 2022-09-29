<?php

namespace App\Http\Controllers\Backend\SystemModule\Products;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\SystemModule\Product;
use App\Models\SystemModule\ProductDetails;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductDetailsController extends Controller
{
    //data function start
    public function data($code){
        if( can('products') ){

            $product = Product::where("code", $code)->select("id")->first();

            if( $product ){

                if( auth('super_admin')->check() ){
                    $product_details = ProductDetails::orderBy("id","desc")->with("group","company","location")->get();
                }
                else{
                    // $auth = auth('web')->user();
                    // $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
    
                    // $product_details = Device::orderBy("id","desc")->with("group","company","location")
                    // ->whereIn("location_id",$user_location)
                    // ->get();
                }
    
                return DataTables::of($product_details)
                ->rawColumns(['action', 'group','company','location'])
                ->editColumn('group', function (ProductDetails $product_details) {
                    return $product_details->group->name;
                })
                ->editColumn('company', function (ProductDetails $product_details) {
                    return $product_details->company->name;
                })
                ->editColumn('location', function (ProductDetails $product_details) {
                    return $product_details->location->name;
                })
                ->addColumn('action', function (ProductDetails $product_details) {
                    return '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$product_details->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown'.$product_details->id.'">
    
                            '.( can("edit_device") ? '
                            <a class="dropdown-item" href="#" data-content="'.route('device.edit.modal',encrypt($product_details->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            ': '') .'
    
                            '.( can("delete_device") ? '
                            <a class="dropdown-item" href="#" data-content="'.route('device.delete.modal',encrypt($product_details->id)).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                            ': '') .'
    
                        </div>
                    </div>
                    ';
                })
                ->addIndexColumn()
                ->make(true);
            }
            else{
                return "No product found";
            }
            
        }else{
            return unauthorized();
        }
    }
    //data function end


    //add_modal function start
    public function add_modal($id){
        try{
            if( can("add_products") ){

                $product = Product::where("id", decrypt($id))->first();

                if( $product ){

                    if( auth('super_admin')->check() ){
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->get();
                    }
                    else{
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type","Group")->pluck("location_id");
                        $groups = Location::where("type","Group")->select("id","name")->where("is_active", true)->whereIn("id",$user_location)->get();
                    }
    
                    return view("backend.modules.system_module.products.modals.add",compact('groups','product'));

                }
                else{
                    return "No products found";
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
    //add_modal function end
}
