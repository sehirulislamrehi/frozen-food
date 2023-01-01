<?php

namespace App\Http\Controllers\Backend\SystemModule\Products;

use App\Http\Controllers\Controller;
use App\Models\LocationModule\Location;
use App\Models\SystemModule\Product;
use App\Models\SystemModule\ProductDetails;
use App\Models\SystemModule\ProductStock;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductDetailsController extends Controller
{
    //data function start
    public function data($id)
    {
        if (can('products')) {

            $product = Product::where("id", $id)->select("id")->first();

            if ($product) {

                if (auth('super_admin')->check()) {
                    $product_details = ProductDetails::orderBy("id", "desc")->with("group", "company", "location")->where("product_id", $product->id)->get();
                } 
                else {
                    $auth = auth('web')->user();
                    $user_location = $auth->user_location->where("type","Location")->pluck("location_id");

                    $product_details = ProductDetails::orderBy("id", "desc")->with("group", "company", "location")
                    ->where("product_id", $product->id)
                    ->whereIn("location_id",$user_location)->get();
                }

                return DataTables::of($product_details)
                    ->rawColumns(['action', 'group', 'company', 'location'])
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
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown' . $product_details->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown' . $product_details->id . '">
    
                            ' . (can("edit_products") ? '
                            <a class="dropdown-item" href="#" data-content="' . route('products.details.edit.modal', encrypt($product_details->id)) . '" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            ' : '') . '

                            ' . (can("stock_summary") ? '
                            <a class="dropdown-item" href="' . route('products.details.stock.summary', encrypt($product_details->id)) . '" class="btn btn-outline-dark">
                                <i class="fas fa-eye"></i>
                                Stock Summary
                            </a>
                            ' : '') . '
    
                        </div>
                    </div>
                    ';
                    })
                    ->addIndexColumn()
                    ->make(true);
            } else {
                return "No product found";
            }
        } else {
            return unauthorized();
        }
    }
    //data function end


    //add_modal function start
    public function add_modal($id)
    {
        try {
            if (can("add_products")) {

                $product = Product::where("id", decrypt($id))->first();

                if ($product) {

                    if (auth('super_admin')->check()) {
                        $groups = Location::where("type", "Group")->select("id", "name")->where("is_active", true)->get();
                    } else {
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type", "Group")->pluck("location_id");
                        $groups = Location::where("type", "Group")->select("id", "name")->where("is_active", true)->whereIn("id", $user_location)->get();
                    }

                    return view("backend.modules.system_module.products.modals.add", compact('groups', 'product'));
                } else {
                    return "No products found";
                }
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //add_modal function end


    //add function start
    public function add(Request $request, $id)
    {
        try {
            if (can('add_products')) {

                $validator = Validator::make($request->all(), [
                    'group_id' =>  'required|integer|exists:locations,id',
                    'company_id' =>  'required|integer|exists:locations,id',
                    'location_id' =>  'required|integer|exists:locations,id'
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                } 
                else {

                    $product = Product::where("id", decrypt($id))->select("id","type","life_time")->first();

                    if( $product ){ 

                        $exists = ProductDetails::select("id")->where("group_id", $request->group_id)
                                    ->where("company_id", $request->company_id)
                                    ->where("location_id", $request->location_id)
                                    ->where("product_id", $product->id)
                                    ->first();

                        if( $exists ){
                            return response()->json(['warning' => 'Details already exists in this location'], 200);
                        }
                        else{

                            $product_details = new ProductDetails();

                            $product_details->product_id = $product->id;
                            $product_details->group_id = $request->group_id;
                            $product_details->company_id = $request->company_id;
                            $product_details->location_id = $request->location_id;
    
                            if( $product_details->save() ){
                                return response()->json(['success' => 'Details created'], 200);
                            }
                        }

                    }
                    else{
                        return response()->json(['warning' => 'No product found'], 200);
                    }
                    
                }
            } else {
                return response()->json(['warning' => unauthorized()], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
    //add function end


    //edit_modal function start
    public function edit_modal($id)
    {
        try {
            if (can("edit_products")) {

                $product_details = ProductDetails::where("id", decrypt($id))->with("group","company","location","product")->first();

                if ($product_details) {

                    if (auth('super_admin')->check()) {
                        $groups = Location::where("type", "Group")->select("id", "name")->where("is_active", true)->get();
                    } 
                    else {
                        $auth = auth('web')->user();
                        $user_location = $auth->user_location->where("type", "Group")->pluck("location_id");
                        $groups = Location::where("type", "Group")->select("id", "name")->where("is_active", true)->whereIn("id", $user_location)->get();
                    }

                    $product = $product_details->product;

                    return view("backend.modules.system_module.products.modals.edit", compact('groups', 'product_details','product'));

                } else {
                    return "No details found";
                }
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //edit_modal function end


    //edit function start
    public function edit(Request $request, $id)
    {
        try {
            if (can('edit_products')) {

                $product_details = ProductDetails::where("id", decrypt($id))->with("product")->first();

                if( $product_details ){ 

                    $product = $product_details->product;

                    if( $request->group_id && $request->company_id && $request->location_id ){

                        $exists = ProductDetails::select("id")->where("group_id", $request->group_id)
                        ->where("company_id", $request->company_id)
                        ->where("location_id", $request->location_id)
                        ->where("product_id", $product_details->product_id)
                        ->first();

                        if( $exists ){
                            return response()->json(['warning' => 'Details already exists in this location'], 200);
                        }
                        else{
                            $product_details->group_id = $request->group_id;
                            $product_details->company_id = $request->company_id;
                            $product_details->location_id = $request->location_id;
                        }

                    }

                    if( $product_details->save() ){
                        return response()->json(['success' => 'Details updated'], 200);
                    }

                }
                else{
                    return response()->json(['warning' => 'No product details found'], 200);
                }
            } 
            else {
                return response()->json(['warning' => unauthorized()], 200);
            }
        } 
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
    //edit function end


    
}
