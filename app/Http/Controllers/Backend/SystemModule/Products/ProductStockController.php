<?php

namespace App\Http\Controllers\Backend\SystemModule\Products;

use App\Http\Controllers\Controller;
use App\Models\ProductionModule\CartoonDetail;
use App\Models\SystemModule\Product;
use App\Models\SystemModule\ProductDetails;
use App\Models\SystemModule\ProductStock;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    //stock_summary function start
    public function stock_summary($id){
        try {
            if (can("stock_summary")) {

                $product_details = ProductDetails::where("id", decrypt($id))->with("group","company","location")->first();

                if ( $product_details ) {
                    $product = Product::where("id", $product_details->product_id)->select("code","name")->first();
                    $product_details_id = $product_details->id;
                    $in_quantity = 0;
                    $out_quantity = 0;

                    $cartoon_details = [];
                    $cartoon_details = CartoonDetail::where("product_details_id", $product_details->id)
                    ->select("quantity","blast_freezer_entries_id","created_at","cartoon_id")->With("cartoon")->paginate(50);


                    return view("backend.modules.system_module.products.pages.stock_summary", compact('product_details','cartoon_details','product','in_quantity','out_quantity'));

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
