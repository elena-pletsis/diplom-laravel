@extends('adminlte::page') 

@section('title', $pageTitle)

@section('content_header')
    <h1>{{$pageTitle}}</h1>
@stop

@section('content')
	@if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@endif
	<table id="table">
		<thead>
			<tr>
				<th>Заказ</th>
				<th>Имя фамилия пользователя</th>
				<th>Email</th>
				<th>Номер телефона</th>
				<th>Адрес</th>
				<th>Статус заказа</th>
				<th>Валюта</th>
				<th>Примечание</th>
				<th>Общая сумма</th>
				<th>Сумма к уплате</th>
				<th>Создан</th>
				<th>Обновлен</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $order)
				<tr>
					<td>
						<a href="/admin/order/{{$order->id}}">{{$order->id}}</a></td>					
					<td>
						{{-- если user_id есть в таблице orders, то значит залогиненный, если null – значит нет --}}
						@if($order->user_id)
						<a href="/admin/order/user/{{$order->user_id}}">{{$order->full_name}}</a>
						@else
						{{$order->full_name}}
						@endif
					</td>
					<td>
						@if($order->user_id)
						<a href="/admin/order/user/{{$order->user_id}}">{{$order->email}}</a>
						@else
						{{$order->email}}
						@endif
					</td>
					<td>{{$order->phone}}</td>
					<td>{{$order->address}}</td>
					<td>{{$order->status->name}}</td>
					<td>{{$order->currency}}</td>
					<td>{{$order->note}}</td>
					<td>{{$order->total_sum}}</td>
					<td>{{$order->sum_to_pay}}</td>
					<td>{{$order->created_at}}</td>	
					<td>{{$order->updated_at}}</td>				
				</tr>

			@endforeach		
		</tbody>
	</table>   
@stop

@section('js')
<script>
	(function($){
        $(document).ready(function(){
	        $('#table').DataTable({








	        });
        });
    })(jQuery);  
</script>

@endsection
