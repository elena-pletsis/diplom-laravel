@extends('adminlte::page') 

@section('title', $pageTitle)

@section('content_header')
    <h1>{{$pageTitle}}</h1>
@stop

@section('content')
@include('layouts.errors')
	@if (session('message'))
		    <div class="alert alert-success">
		        {{ session('message') }}
		    </div>
	@endif
	<form action="/admin/users" method="POST">
		@csrf
		<div class="form-group">
			<label for="fname">Имя:</label>
			<input type="text" class="form-control" id="fname" name="fname" required="required">
		</div>
		<div class="form-group">
			<label for="lname">Фамилия:</label>
			<input type="text" class="form-control" id="lname" name="lname" required="required">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" autocomplete="off" required="required">
		</div>
		<div class="form-group">
			<label for="password">Пароль:</label>
			<input type="password" class="form-control" id="password" name="password" autocomplete="off" required="required">
		</div>
		<div class="form-group">
			<label for="address">Адрес:</label>
			<input type="text" class="form-control" id="address" name="address">
		</div>
		<div class="form-group">
			<label for="phone">Номер телефона:</label>
			<input type="text" class="form-control" id="phone" name="phone">
		</div>
		<div class="form-group">
			<label for="roles">Роли:</label>
			<select class="form-control" id="roles" name="roles[]" multiple>
				@foreach($roles as $role)
				<option value="{{$role->id}}">{{$role->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="checkbox">
 			<label><input type="checkbox" name="club_member">Член клуба "Мокрый нос"</label>
 		</div>
		{{-- button.btn.btn-primary>{Save} --}}
		<button class="btn btn-primary">Сохранить</button>
	</form>
@stop

@section('js')
<script>
	$(document).ready( function () {
    	$('#roles').select2();
	} );
	// $(document).ready( function () {
 //    	$('#table').DataTable();
	// } );
</script>>

@endsection