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
    public function productPage(Request $request){
        $request -> product()->all;
        return response($request);
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
