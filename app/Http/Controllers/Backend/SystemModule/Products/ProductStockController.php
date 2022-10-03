<?php

namespace App\Http\Controllers\Backend\SystemModule\Products;

use App\Http\Controllers\Controller;
use App\Models\SystemModule\Product;
use App\Models\SystemModule\ProductDetails;
use App\Models\SystemModule\ProductStock;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductStockController extends Controller
{
    //stock_add_modal function start
    public function stock_add_modal($id)
    {
        try {
            if (can("stock_entry")) {

                $product_details = ProductDetails::where("id", decrypt($id))->select("id","group_id","company_id","location_id")->with("group","company","location")->first();

                if ($product_details) {

                    return view("backend.modules.system_module.products.modals.stock_entry", compact('product_details'));

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
    //stock_add_modal function end


    //stock_add function start
    public function stock_add(Request $request, $id){
        try {
            if (can('edit_products')) {

                $validator = Validator::make($request->all(), [
                    'type' => 'required|in:In,Out',
                    'quantity' => 'required|numeric|min:0|not_in:0'
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                } 
                else {

                    $product_details = ProductDetails::where("id", decrypt($id))->first();

                    if( $product_details ){ 

                        $product_stocks = new ProductStock();

                        $product_stocks->product_details_id = $product_details->id;
                        $product_stocks->quantity = $request->quantity;
                        $product_stocks->type = $request->type;
                        $product_stocks->date_time = Carbon::now()->toDateTimeString();

                        if( $request->type == "In" ){
                            $product_details->quantity += $request->quantity;
                        }

                        if( $request->type == "Out" ){
                            $product_details->quantity -= $request->quantity;

                            if( $product_details->quantity < 0 ){
                                return response()->json(['warning' => 'Stock quantity cannot be negative.'], 200);
                            }
                        }

                        if( $product_stocks->save() ){

                            

                            if( $product_details->save() ){
                                return response()->json(['success' => 'Stock updated'], 200);
                            }

                        }

                    }
                    else{
                        return response()->json(['warning' => 'No product details found'], 200);
                    }
                    
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
    //stock_add function end


    //stock_summary function start
    public function stock_summary($id){
        try {
            if (can("stock_summary")) {

                $product_details = ProductDetails::where("id", decrypt($id))->with("group","company","location")->first();

                if ( $product_details ) {

                    $product_stocks = ProductStock::where("product_details_id", $product_details->id)->select("quantity","type","date_time")->paginate(10);
                    $product = Product::where("id", $product_details->product_id)->select("code","name")->first();

                    return view("backend.modules.system_module.products.pages.stock_summary", compact('product_details','product_stocks','product'));

                } 
                else {
                    return back()->with('error', 'No details found');
                }
            } else {
                return view("errors.403");

            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    //stock_summary function end
}
