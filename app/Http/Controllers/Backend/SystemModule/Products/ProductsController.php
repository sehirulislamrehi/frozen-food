<?php

namespace App\Http\Controllers\Backend\SystemModule\Products;

use App\Http\Controllers\Controller;
use App\Models\SystemModule\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    //index function start
    public function index(){
        try{
            if( can("products") ){
                return view("backend.modules.system_module.products.index");
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
                    'code' =>  'required|unique:products,code|integer',
                    'name' =>  'required|unique:products,name',
                    'factor' =>  'required|in:Packet',
                    'type' => 'required|in:Local,Export',
                    'is_active' => 'required|in:0,1',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                
                    $product = new Product();

                    $product->code = $request->code;
                    $product->name = $request->name;
                    $product->factor = $request->factor;
                    $product->type = $request->type;

                    $product->life_time = ( $request->type == "Local" ) ? 1 : 2;
 
                    $product->is_active = $request->is_active;
                    
                    if( $product->save() ){
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Product uploaded',
                            'redirect' => route('products.edit.page', $product->code)
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


    //edit_page function start
    public function edit_page($code){
        try{
            if( can("edit_products") ){

                $product = Product::where("code", $code)->first();

                if( $product ){
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
                    'code' =>  'required|integer|unique:products,code,'. $id,
                    'name' =>  'required|unique:products,name,'. $id,
                    'factor' =>  'required|in:Packet',
                    'type' => 'required|in:Local,Export',
                    'is_active' => 'required|in:0,1',
                ]);
                
    
               if( $validator->fails() ){
                   return response()->json(['errors' => $validator->errors()] ,422);
               }
               else{
                
                    $product = Product::where("id", $id)->first();

                    if( $product ){

                        $product->code = $request->code;
                        $product->name = $request->name;
                        $product->factor = $request->factor;
                        $product->type = $request->type;

                        $product->life_time = ( $request->type == "Local" ) ? 1 : 2;

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
