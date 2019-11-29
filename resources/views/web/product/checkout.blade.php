@extends('layouts.app')

@section('content')
<div class="container">
	@include('layouts.errors')
	@if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    <h1>Оформление заказа</h1>
    <h2 class="mt-3">Ваш заказ:</h2>


@foreach(session('cart') as $product)
<div class="row product">
    <div class="col-2">
        <img src="{{$product['img']}}" alt="" class="img-fluid">
    </div>
    <div class="col-10">
       <h4>{{$product['title']}}</h4> 
       {{$product['qty']}} * {{$product['price']}} =  
       {{$product['qty'] * $product['price']}}       
    </div>    
</div>
@endforeach
<div class="row product">
	<div class="col-2">
		<hr>
		<h5>Итого:</h5>
	</div>
	<div class="col-10">
		<hr>
		Количество товара:  {{session('TotalQty')}} шт.
		<br>
		Общая сумма: {{session('TotalSum')}} грн.
		  @if(session('Discount') > 0)
		    <br>
		    Ваша скидка: {{session('Discount')}} %
		    <br>
		    Сумма к оплате: {{session('SumToPay')}} грн.    
		  @endif          
	</div>
</div>

	<h2 class="mt-3">Ваши данные:</h2>
	<form action="/buy" method="POST">
		@csrf
		{{-- если пользователь авторизированный, то мы будем посылать его id --}}
		<input type="hidden" name="user_id" class="form-control" @auth value="{{Auth::user()->id}}" @endauth> 

		<div class="form-group">
			<label for="full_name">Имя фамилия* :</label>
			<input type="text" id="full_name" name="full_name" class="form-control" @auth value="{{Auth::user()->full_name}}" @endauth required="required">
		</div>
		<div class="form-group">
			<label for="email">Email* :</label>
			<input type="text" id="email" name="email" class="form-control" @auth value="{{Auth::user()->email}}" @endauth required="required">
		</div>
		<div class="form-group">
			<label for="phone">Номер телефона* (формат ввода: +380501111111) :</label>
			<input type="text" id="phone" name="phone" class="form-control" @auth value="{{Auth::user()->phone}}" @endauth required="required">
		</div>
		<div id="delivery">
			<div class="delivery-header">
				<p>Доставка:</p>
				<img src="images/NPlogo.png" alt=""/ style="max-width: 11%;">
			</div>
			{{-- {{dd($npareas)}} --}}
			<div class="form-group">
				<label for="npareas">Область* :</label>
				<select class="form-control" id="npareas" name="npareas" required="required">
					<option value="0" selected disabled>Выберите область</option> 
					@foreach($npareas as $area)
					<option value="{{$area->Ref}}">{{$area->Description}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="npcities">Населенный пункт* :</label>
				<select class="form-control" id="npcities" name="npcities" required="required">
					<option value="0" selected disabled>Выберите населенный пункт</option>   
					{{-- перебор в ajax --}}
				</select>
			</div>
			<div class="form-group">
				<label for="npwarehouses">Отделение* :</label>
				<select class="form-control" id="npwarehouses" name="npwarehouses" required="required">
					<option value="0" selected disabled>Выберите отделение Новой Почты</option>	
					{{-- перебор в ajax --}}							
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="note">Примечание:</label>
			<input type="text" class="form-control" id="note" name="note">
		</div>

		<button class="btn submit-checkout">Оформить заказ</button>
	</form>
    
            
</div>    
@endsection

@section('js')
	<script>
	(function($){
        $(document).ready(function(){

        	$('#npareas').on('change', function(){
        		//console.log($('#npareas').val());
        		$.ajax({
	        		type: 'POST',
					url: '/choose-nparea',
					dataType: 'json',
					data: {
						areaRef: $('#npareas').val(),
					},
					success: function(response){
						$.each(response, function(key, value) {
						 $("#npcities").append(`<option value="${value.Ref}">${value.SettlementTypeDescriptionRu} ${value.DescriptionRu}</option>`);
						});
					}
        		});
        	});


        	$('#npcities').on('change', function(){
        		$.ajax({
	        		type: 'POST',
					url: '/choose-npcity',
					dataType: 'json',
					data: {
						cityRef: $('#npcities').val(),
					},
					success: function(response){
						$.each(response, function(key, value){
							$("#npwarehouses").append(`<option value="${value.DescriptionRu}">${value.DescriptionRu}</option>`)
						});
					}
        		});
        	});


		});	  
    })(jQuery);  
</script>
@endsection




