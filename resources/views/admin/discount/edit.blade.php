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

	<form action="/admin/discount/{{$discount->id}}" method="POST">
		<input type="hidden" name="_method" value="PUT">
		{{csrf_field()}}
		<div class="form-group">
			<label for="name">Название:</label>
			<input type="text" class="form-control" id="name" name="name" value="{{$discount->name}}">
		</div>
		<div class="form-group">
			<label for="discount">Скидка:</label>
			<input type="text" class="form-control" id="discount" name="discount" value="{{$discount->discount}}">
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