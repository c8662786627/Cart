<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    //
      /**
     * 顯示購物車內容
     */
    public function index()
    {
        //$product = product::findOrFail($product_id);
        $user = Auth::user();
        $cart = Cart::findOrFail($user->id);
        


        return response($cart);
    }

    /**
     * 新增購物車項目
     */
    public function store(Request $request)
    {
        

        $validator = Validator::make($request->all(),[
            'number'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->first();
        if(!$cart) {
            // 如果找不到購物車的使用者資料，就建立一筆新的使用者資料
            $cart = new Cart;
            $cart->user_id=$user->id;
            $cart->total=0;
            $cart->save();
            
        }

        $product = Product::find($request->product_id);
        $cartItem = CartItem::where('product_id',$product->id)
                            ->where('cart_id',$cart->id)
                            ->first();
        if(!$cartItem) {
            // 如果找不到對應的商品，就建立一筆新的商品資料
            $cartItem = new CartItem;
            $cartItem->product_id=$product->id;
            $cartItem->number=$request->number;
            $cartItem->cart_id=$cart->id;
            $cartItem->save();
            //並且更新金額
            $cart->update([
                'total'=> $cart->total += $product->price,
            ]);
        }else{
            $cartItem->update([
                'number'=> $cartItem->number+=$request->number,
            ]);
            $cart->update([
                'total'=> $cart->total += $product->price,
            ]);
        }

        return response($cart);


    }

    /**
     * 更新購物車項目
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'number'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->first();
        $product = Product::find($request->product_id);
        $cartItem = CartItem::where('product_id',$product->id)
                            ->where('cart_id',$cart->id)
                            ->first();

        
        $cart->update([
            'total'=> $cart->total =$cart->total - $cartItem->number * $product->price + $request->number * $product->price,
        ]);
        $cartItem->update([
            'number'=> $request->number,
        ]);
        
        return response($cart);
    }

    /**
     * 刪除購物車項目
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->first();
        $product = Product::find($request->product_id);
        $cartItem = CartItem::where('product_id',$product->id)
                            ->where('cart_id',$cart->id)
                            ->first();
        if ($cartItem) {
            $cart->update([
                'total'=> $cart->total =$cart->total - $cartItem->number * $product->price,
            ]);
        
            $cartItem->delete();
        }
        return response($cart);
    }
}
