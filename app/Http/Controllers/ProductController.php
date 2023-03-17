<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function listPage(Request $request){

    }
    public function productPage($product_id){
        $product = product::findOrfail($product_id);

        
       if(!is_null($product->photo)){
            $product->photo = url($product->photo);
        }
        $binding=[
            'title'=>'編輯商品',
            'product'=> $product,
            
        ];
        
        return view('product/editproduct',$binding);
    }
    public function productCreate(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $product = product::create([
            'status'=>'C',
            'name' =>$request->name,
            'introduction' =>$request->introduction,
            'photo' =>$request->photo,
            'price' =>$request->price,
            'count' =>$request->count,
        ]);
        return response($product);
    }
    public function productUpdate(Request $request){

    }
    public function productDel(Request $request){

    }
}
