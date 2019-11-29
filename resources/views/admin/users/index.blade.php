@extends('adminlte::page') 

@section('title', $pageTitle)

@section('content_header')
    <h1>{{$pageTitle}}</h1>
@stop

@section('content')
{{-- https://laravel.com/docs/5.8/redirects#redirecting-with-flashed-session-data --}}
	@if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@endif
	<table id="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Имя фамилия</th>
				<th>Email</th>
				<th>Адрес</th>
				<th>Номер телефона</th>
				<th>Роли</th>
				<th>Член клуба "Мокрый нос"</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)				
				<tr data-id="{{$user->id}}">
					<td>{{$loop->iteration}}</td>
					<td class="user-name">
						{{$user->full_name}}
						<div class="user-edit">
							<a href="/admin/users/{{$user->id}}/edit" class="btn-link">Редактировать</a>
							<form action="/admin/users/{{$user->id}}" method="POST">
								<input type="hidden" name="_method" value="DELETE">
								{{csrf_field()}}
								<button class="delete btn-link" style="width: 80px">Удалить</button>
							</form>
						</div>
					</td>
					<td>{{$user->email}}</td>
					<td>{{$user->address}}</td>
					<td>{{$user->phone}}</td>
					<td>{{$user->roles->implode('name', ', ')}}</td> 
					{{-- roles - это коллекция из модели метод Модели стал свойством --}}
					<td>
						<i class="edit-club-member fa-lg fa fa-chevron-down {{$user->club_member?'text-danger':'text-success'}}"></i>	
					</td>
				</tr>
				{{-- {{dd($user)}} --}}
			@endforeach		
		</tbody>
	</table>   
@stop

@section('js')
<script>
	(function($){
        $(document).ready(function(){
	        $('#table').DataTable({
	        	// drawCallback, функция, которая вызывается каждый раз, когда DataTables выполняет отрисовку.
	        	 "drawCallback": function( settings ) {  
        			$( ".user-name" )
			  		.on( "mouseenter", function() {
			  			$(this).find('.user-edit').addClass('visible');
					})
					.on( "mouseleave", function() {
			  			$(this).find('.user-edit').removeClass('visible');
					});
    			}
	        });
        });
    })(jQuery);  
</script>

@endsection

	