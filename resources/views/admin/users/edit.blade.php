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
	<form action="/admin/users/{{$user->id}}" method="POST">
		<input type="hidden" name="_method" value="PUT">
		{{csrf_field()}}
		<div class="form-group">
			<label for="fname">Имя:</label>
			<input type="text" class="form-control" id="fname" name="fname" value="{{$user->first_name}}">
		</div>
		<div class="form-group">
			<label for="lname">Фамилия:</label>
			<input type="text" class="form-control" id="lname" name="lname" value="{{$user->last_name}}">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
		</div>
		<div class="form-group">
			<label for="address">Адрес:</label>
			<input type="text" class="form-control" id="address" name="address" value="{{$user->address}}">
		</div>
		<div class="form-group">
			<label for="phone">Номер телефона:</label>
			<input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}">
		</div>

		<div class="form-group">
			<label for="new_password">Новый пароль (если необходимо):</label>
			<input type="password" class="form-control" id="new_password" name="new_password">
		</div>
		<div class="form-group">
			<label for="roles">Роли:</label>
			<select class="form-control" id="roles" name="roles[]" multiple>
				@foreach($roles as $role)
					<option 
					{{(($userRoles->contains('id', $role->id)) ? 'selected' : '')}} 
					value="{{$role->id}}">{{$role->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="checkbox">
 			<label><input type="checkbox" name="club_member" value="{{$user->club_member}}" {{ $user->club_member == 1 ? 'checked' : '' }}>Член клуба "Мокрый нос"</label>
 		</div>
		<button class="btn btn-primary">Сохранить</button>
	</form>
@stop

@section('js')
<script>
	$(document).ready( function () {
    	$('#roles').select2();
	} );
</script>
@endsection