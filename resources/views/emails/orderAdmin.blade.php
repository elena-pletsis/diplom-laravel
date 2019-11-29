<h1>Заказ № {{$order->id}}</h1>
@foreach(session('cart') as $product)
{{-- .row.product>.col-3+.col-8+.col-1 --}}
<div class="row product">
    <div class="col-3">
        <img src="<?php echo $message->embed(public_path().$product['img']); ?>" alt="" class="img-fluid">
    </div>
    <div class="col-8">
       <h4>{{$product['title']}}</h4> 
       {{$product['qty']}} * {{$product['price']}} =  {{$product['qty'] * $product['price']}}
    </div>    
</div>

@endforeach