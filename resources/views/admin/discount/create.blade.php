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
	<form action="/admin/discount" method="POST">
		@csrf
		<div class="form-group">
			<label for="name">Название:</label>
			<input type="text" class="form-control" id="name" name="name" required="required">
		</div>
		<div class="form-group">
			<label for="discount">Скидка:</label>
			<input type="text" class="form-control" id="discount" name="discount" pattern="[0-9]+" required="required">
		</div>		
		{{-- button.btn.btn-primary>{Save} --}}
		<button class="btn btn-primary">Сохранить</button>
	</form>
@stop

@section('js')
<script>
	// $(document).ready( function () {
 //    	$('#roles').select2();
	// } );
	// $(document).ready( function () {
 //    	$('#table').DataTable();
	// } );
</script>>

@endsection