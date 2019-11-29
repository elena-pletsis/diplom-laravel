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

	<form action="/admin/category" method="POST">
		{{csrf_field()}}
		<div class="form-group">
			<label for="title">Название:</label>
			<input type="text" class="form-control" id="title" name="title" required="required">
		</div>
		<div class="form-group">
			<label for="slug">Слаг:</label>
			<input type="text" class="form-control" id="slug" name="slug">
		</div>
		<div class="form-group">
			<label for="parentId">Родительская категория:</label>
			<select class="form-control" id="parentId" name="parentId">
				<option value="0"></option> 
				@foreach($categories as $category)
				<option value="{{$category->id}}">{{$category->title}}</option>
				@endforeach
			</select>
		</div>
		<div class="input-group">
		   <span class="input-group-btn">
		     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
		       <i class="fa fa-picture-o"></i> Выбрать изображение
		     </a>
		   </span>
		   <input id="thumbnail" class="form-control" type="text" name="filepath">
		 </div>
 		<img id="holder" style="margin-top:15px;max-height:100px;">
		<button class="btn btn-primary" style="margin-top:1%;">Сохранить</button>
	</form>
@stop

@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
 $('#lfm').filemanager('image');
</script>
@endsection