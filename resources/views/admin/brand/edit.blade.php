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
	
	<form action="/admin/brand/{{$brand->id}}" method="POST">
		<input type="hidden" name="_method" value="PUT">
		{{csrf_field()}}

		<div class="form-group">
			<label for="title">Название:</label>
			<input type="text" class="form-control" id="title" name="title" value="{{$brand->title}}">
		</div>
		<div class="form-group">
			<label for="slug">Слаг:</label>
			<input type="text" class="form-control" id="slug" name="slug" value="{{$brand->slug}}">
		</div>
		<div class="input-group">
		   <span class="input-group-btn">
		     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
		       <i class="fa fa-picture-o"></i> Выбрать изображение
		     </a>
		   </span>
		   <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{$brand->img}}">
		 </div>
 		<img src="{{$brand->img}}" id="holder" style="margin-top:15px;max-height:100px;">
 		@if($brand->img)
 			<div class="checkbox">
 				<label><input type="checkbox" class="remove-img" name="remove">Удалить изображение</label>
 			</div>
 		@endif
 		<div class="form-group">
			<label for="description">Описание:</label>
			<textarea class="form-control" id="description" name="description" >{{$brand->description}}</textarea>		
		</div>
		<button class="btn btn-primary">Сохранить</button>		
	</form>
@stop

@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
	$('#lfm').filemanager('image');

	$(document).ready( function () {
    	$('#roles').select2();
	} );

	$('#thumbnail').change(function(){
		if( $(this).val() ){
			$('.remove-img').prop('checked', false)
		}
	});
</script>>
@endsection