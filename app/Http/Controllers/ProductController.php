<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function listPage(Request $request){
        $row=10;
        $productpageinate = product::orderby('created_at','desc')->paginate($row);
        $binding=[
            'title'=>'商品瀏覽',
            'productpageinate'=>$productpageinate,

        ];
        return view('product/productlist',$binding);
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
    public function productUpdate(Request $request,$product_id){

        $product = product::findOrFail($product_id);
        $input = $request->all();
       
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
            'photo' =>'image',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->update([
            'status'=>$input['status'],
            'name'=>$input['status'],
            'introduction'=>$input['introduction'],
            //'photo'=>$input->photo,
            'price'=>$input['price'],
            'count'=>$input['count'],
        ]);

        if (isset($input['photo'])) {
            $d=$product->photo;
            if(!is_null($d) && file_exists($d)){
                unlink($d);
            }
            $photo = $input['photo'];
            $file_extension = $photo -> getClientOriginalExtension();
            $file_name = uniqid().'.'.$file_extension;
            $file_relative_path = 'img/'.$file_name;
            $product->update(['photo'=>$file_relative_path]);
            // 將圖片文件存儲到 public 目錄下的 images 文件夾中，並為文件取一個唯一的名稱
            $path = $request->photo->move(public_path('img'), $file_relative_path);
       
         
        }
       
        return redirect('product/'.$product_id);
        
    }
    public function productDel(Request $request,$product_id){
        $product = product::FindorFail($product_id);
        $d=$product->photo;
            if(!is_null($d) && file_exists($d)){
                unlink($d);
            }
        $product->delete();
        return response('刪除成功');

    }
}
