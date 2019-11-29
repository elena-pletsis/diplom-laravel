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
				<th>Id</th>
				<th>id товара</th>
				<th>Название товара</th>
				<th>id пользователя</th>
				<th>User name</th>
				<th>Text</th>				
			</tr>
		</thead>
		<tbody>
			@foreach ($reviews as $review)
				<tr>
					<td>{{$review->id}}</td>
					<td>{{$review->product_id}}</td>
					<td><a href="/admin/review/product/{{$review->product_id}}">{{$review->product->title}}</a></td>
					{{-- ?? просмотреть все отзывы по продукту --}}
					<td>{{$review->user_id}}</td> 
					<td><a href="/admin/review/user/{{$review->user_id}}">{{$review->user_name}}</a></td> 
					{{-- ?? просмотреть все отзывы пользователя --}}
					<td>{{$review->review_text}}</td>								
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
