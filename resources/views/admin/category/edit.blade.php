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
	
	<form action="/admin/category/{{$category->id}}" method="POST">
		<input type="hidden" name="_method" value="PUT">
		{{csrf_field()}}

		<div class="form-group">
			<label for="title">Название:</label>
			<input type="text" class="form-control" id="title" name="title" value="{{$category->title}}">
		</div>
		<div class="form-group">
			<label for="slug">Слаг:</label>
			<input type="text" class="form-control" id="slug" name="slug" value="{{$category->slug}}">
		</div>
		{{-- {{dd($category)}} --}}
		<div class="form-group">
			<label for="parentId">Родительская категория:</label>
			<select class="form-control" id="parentId" name="parentId">
				<option value="{{$category->parent? $category->parent->id : ""}}">{{ $category->parent ? $category->parent->title : ""}}</option> 
				@foreach($categories as $cat)
					{{-- @if($category->parent && $cat->id !== $category->parent->id) --}}
						<option value="{{$cat->id}}">{{$cat->title}}</option>
					{{-- @endif --}}
				@endforeach
			</select>
		</div>
		<div class="input-group">
		   <span class="input-group-btn">
		     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
		       <i class="fa fa-picture-o"></i> Выбрать изображение
		     </a>
		   </span>
		   <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{$category->img}}">
		 </div>
 		<img src="{{$category->img}}" id="holder" style="margin-top:15px;max-height:100px;">
 		@if($category->img)
 			<div class="checkbox">
 				<label><input type="checkbox" class="remove-img" name="remove">Удалить изображение</label>
 			</div>
 		@endif
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

	// $('.remove-img').click(function(){
	// 	if( $(this).prop('checked') ){
	// 		$('#thumbnail').val('');
	// 		$('#holder').attr('src', '');
	// 	}
	// });

	$('#thumbnail').change(function(){
		if( $(this).val() ){
			$('.remove-img').prop('checked', false)
		}
	});
</script>>
@endsection