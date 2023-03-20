@extends('layout.master')

@section('title',$title)

@section('content')
<div class="container">
    <h1>{{$title}}</h1>
<table>
    <tr>
        <th>商品名稱</th>
        <th>商品圖片</th>
        <th>狀態</th>
        <th>價格</th>
        <th>數量</th>
        <th>編輯</th>
        <th>刪除</th>
    </tr>
    @foreach($productpageinate as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>
            @if(!empty($product->photo))
                <img src="/{{ $product->photo }}" alt="" style="width:50px;">
            @else
                <img src="/img/product.jpg" alt="" style="width:50px;">
            @endif
        </td>
        <td>
            @if($product->status =='C')
            建立中
            @else
            販售中
            @endif
        </td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->count }}</td>
        <td><a href="/product/{{$product->id}}">編輯</a></td>
        <td><a href="/product/{{$product->id}}/delete">刪除</a></td>
    </tr>
    @endforeach
</table>


    
</div>

@endsection