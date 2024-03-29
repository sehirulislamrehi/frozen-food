<?php

namespace App\Http\Controllers\Backend\SystemModule\Products;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\SystemModule\Product;
use App\Models\SystemModule\ProductDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Excel;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    //index function start
    public function index(Request $request){
        try{
            if( can("products") ){

                $search = $request->search;
                // if( auth('super_admin')->check() ){

                    if( $search ){
                        $products = Product::orderBy("id","desc")
                        ->where("code","LIKE","%$search%")
                        ->orWhere("name","LIKE","%$search%")
                        ->orWhere("factor","LIKE","%$search%")
                        ->orWhere("type","LIKE","%$search%")
                        ->paginate(50);
                    }
                    else{
                        $products = Product::orderBy("id","desc")->paginate(50);
                    }
                    
                // }
                // else{
                //     $auth = auth('web')->user();
                //     $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                //     $product_ids = ProductDetails::whereIn("location_id", $user_location)->select("product_id")->groupBy("product_id")->pluck("product_id");

                //     if( $search ){
                //         $products = Product::orderBy("id","desc")->whereIn("id",$product_ids)
                //         ->where("code","LIKE","%$search%")
                //         ->orWhere("name","LIKE","%$search%")
                //         ->orWhere("factor","LIKE","%$search%")
                //         ->orWhere("type","LIKE","%$search%")
                //         ->paginate(50);
                //     }
                //     else{
                //         $products = Product::orderBy("id","desc")->whereIn("id",$product_ids)->paginate(50);
                //     }

                    
                // }

                return view("backend.modules.system_module.products.index", compact("products","search"));
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


    //add_page function start
    public function add_page(){
        try{
            if( can("add_products") ){
                
                $factors = factor();

                return view("backend.modules.system_module.products.pages.add", compact("factors"));
            }
            else{
                return view("errors.403");
            }
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    } 
    //add_page function end


    //add function start
    public function add(Request $request){
        try{
            if( can('add_products') ){

                $validator = Validator::make($request->all(),[
                    // 'code' =>  'required|unique:products,code|integer',
                    'name' =>  'required|unique:products,name',
                    // 'factor' =>  'required|integer|min:1',
                    'type' => 'required|in:Local,Export',
                    'is_active' => 'required|in:0,1',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                
                    $product = new Product();

                    $product->code = $request->code ?? null;
                    $product->name = $request->name;
                    $product->factor = $request->factor ?? null;
                    $product->type = $request->type;

                    $product->life_time = ( $request->type == "Local" ) ? product_life_time("Local") : product_life_time("Export");
 
                    $product->is_active = $request->is_active;
                    
                    if( $product->save() ){
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Product uploaded',
                            'redirect' => route('products.edit.page', $product->id)
                        ], 200);
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


    //import function start
    public function import(Request $request){
        try{
            if( can('add_products') ){
                $files = $request->file('file');
                $type = $request->file('file')->getClientOriginalExtension();
                

                if( $type == "csv" ){
                    $result = [];

                    $file = fopen($_FILES["file"]["tmp_name"], "r");
                    $row = 1;
                    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        $row++;
                        array_push($result,[
                            'code' => utf8_encode($data[0]),
                            'name' => utf8_encode($data[1]),
                            'type' => utf8_encode($data[2]),
                            'life_time' => product_life_time(utf8_encode($data[2])),
                            'is_active' => true
                        ]);
                    }

                    try{
                        DB::table("products")->insert($result);
                    }
                    catch( Exception $e ){
                        $code = DB::select("SELECT code FROM products ORDER BY id DESC LIMIT 1");

                        if( isset($code[0]) ){
                            $code = $code[0]->code;
                        }

                        return redirect()->back()->with('error', $e->getMessage() . ' Last entry code : '.$code.'');
                    }

                    return redirect()->back()->with('success', 'Product inserted');

                }
                else{
                    return redirect()->back()->with('warning', 'Please upload .csv format');
                }
            }
            else{
                return view("errors.403");
            }
        }
        catch( Exception $e ){
            return redirect()->back()->with('error', $e->getMessage());
        }
    } 
    //import function end


    //edit_page function start
    public function edit_page($id){
        try{
            if( can("edit_products") ){

                $product = Product::where("id", $id)->first();

                if( $product ){

                    // if( auth('web')->check() ){
                    //     $auth = auth('web')->user();
                    //     $user_location = $auth->user_location->where("type","Location")->pluck("location_id");
                    //     $product_ids = ProductDetails::whereIn("location_id", $user_location)->select("product_id")->groupBy("product_id")->get();
                        
                    //     if( !$product_ids->where("product_id", $product->id)->first() ){
                    //         return back()->with('warning', 'You are not accessible for the product');
                    //     }

                    // }

                    $factors = factor();
                    return view("backend.modules.system_module.products.pages.edit", compact("factors","product"));
                }
                else{
                    return back()->with('warning', 'No product found');
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
    //edit_page function end


    //edit function start
    public function edit(Request $request, $id){
        try{
            if( can('edit_products') ){
                $id = decrypt($id);
                $validator = Validator::make($request->all(),[
                    // 'code' =>  'required|integer|unique:products,code,'. $id,
                    'name' =>  'required|unique:products,name,'. $id,
                    // 'factor' =>  'required|integer|min:1',
                    'type' => 'required|in:Local,Export',
                    'is_active' => 'required|in:0,1',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                
                    $product = Product::where("id", $id)->first();

                    if( $product ){

                        if( $product->type != $request->type ){
                            $product_details = ProductDetails::where("product_id", $product->id)->get();
                            foreach( $product_details as $product_detail ){
                                $explode = explode("-", $product_detail->manufacture_date);

                                if( $request->type == "Local" ){
                                    $product_detail->expiry_date = $explode[0] + product_life_time("Local") .'-'. $explode[1] .'-'. $explode[2];
                                }
        
                                if( $request->type == "Export" ){
                                    $product_detail->expiry_date = $explode[0] + product_life_time("Export") .'-'. $explode[1] .'-'. $explode[2];
                                }

                                $product_detail->save();
                            }
                        }

                        $product->code = $request->code ?? null;
                        $product->name = $request->name;
                        $product->factor = $request->factor ?? null;
                        $product->type = $request->type;

                        $product->life_time = ( $request->type == "Local" ) ? product_life_time("Local") : product_life_time("Export");

                        $product->is_active = $request->is_active;
                        
                        if( $product->save() ){

                            return response()->json(['success' => 'Product updated'], 200);
                        }
                    }
                    else{
                        return response()->json(['warning' => 'No product found'],200);
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
