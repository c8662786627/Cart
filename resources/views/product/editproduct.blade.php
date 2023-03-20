@extends('layout.master')

@section('title',$title)

@section('content')
    <div class="container">
        <h1>{{$title}}</h1>
        
        <form method="post" enctype="multipart/form-data" action="/product/{{$product->id}}">
            <label for="">
                商品狀態
                <select name="status" id="">
                    <option value="C" @if(old('status',$product->status=='C'))
                        select @endif>
                        建立中
                    </option>
                    <option value="S"@if(old('status',$product->status=='S'))
                        select @endif>
                        可販售
                    </option>
                </select>
            </label>
            <label for="">
                商品名稱:
                <input type="text" name="name" placeholder="商品名稱" value="{{old('name', $product->name)}}">
            </label>
            <label for="">
                商品照片:
                <input type="file" name="photo" placeholder="商品圖片">
                @if(!empty($product->photo))
                <img src="{{ $product->photo }}" alt="" style="width:50px;">
                @else
                <img src="/img/product.jpg" alt="" style="width:50px;">
                @endif
                
            </label>
            <label for="">
                商品介紹:
                <input type="text" name="introduction" placeholder="商品介紹" value="{{old('introduction',$product->introduction)}}">
            </label>
            <label for="">
                商品價格:
                <input type="text" name="price" placeholder="商品價格" value="{{old('price',$product->price)}}">
            </label>
            <label for="">
                商品數量:
                <input type="text" name="count" placeholder="商品數量" value="{{old('count',$product->count)}}">
            </label>
            <button type="submit">更改商品資訊</button>
            {{csrf_field()}}
        </form>
    </div>
@endsection