@if( session('cart') )

{{-- {{ dump(session('cart'))}} --}}

@foreach(session('cart') as $product)
{{-- .row.product>.col-3+.col-8+.col-1 --}}

<div class="row product align-items-center">    
    <div class="col-2 text-center">
        <img src="{{$product['img']}}" alt="" class="img-fluid">
    </div>
    <div class="col-3 text-center">
      <p>{{$product['title']}}</p>         
    </div>
    <div class="col-2 input-group justify-content-center" data-id={{$product['id']}}>
      <input type="button" value="-" class="button-minus-product" data-field="quantity" {{$product['qty'] == 1 ? 'disabled' : ''}}>
      <input type="number" step="1" min="1" max="{{$product['dbquantity']}}" value="{{$product['qty']}}" name="quantity" class="quantity-field" 
      >
      <input type="button" value="+" class="button-plus-product" data-field="quantity">       
    </div>
    <div class="col-3 justify-center">  
      <div class="d-flex justify-content-end align-items-center">      
        <input type="text" value="{{$product['qty'] * $product['price']}}" name="sum" class="form-control text-center mr-1 sum-field">   
      <span>грн.{{-- {{$currency['title']}}     --}}</span>
      </div>      
    </div>
    <div class="col-2">
        {{-- i.fa.fa-trash.fa-lg.text-danger --}}
        <i class="fa fa-trash fa-lg text-danger remove-product" data-id={{$product['id']}}></i>
      {{--  {{dd(Cart)}} --}}
    </div>
</div>
@endforeach
<hr>

Количество товара в корзине:  {{session('TotalQty')}} шт.
<br>
Общая сумма: {{session('TotalSum')}} грн.
  @if(session('Discount') > 0)
    <br>
    Ваша скидка: {{session('Discount')}} %
    <br>
    Сумма к оплате: {{session('SumToPay')}} грн.    
  @endif  
@else
  <p>Корзина пуста</p>
@endif
