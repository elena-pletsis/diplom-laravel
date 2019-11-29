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
	
	<form action="/admin/product/{{$product->id}}" method="POST">
		<input type="hidden" name="_method" value="PUT">
		{{csrf_field()}}

		<div class="form-group">
			<label for="title">Название:</label>
			<input type="text" class="form-control" id="title" name="title" value="{{$product->title}}">
		</div>
		<div class="form-group">
			<label for="slug">Слаг:</label>
			<input type="text" class="form-control" id="slug" name="slug" value="">
		</div>
		<div class="form-group">
			<label for="price">Цена:</label>
			<input type="text" class="form-control" id="price" name="price" value="{{$product->price}}">
		</div>
		<div class="form-group">
			<label for="old_price">Старая цена:</label>
			<input type="text" class="form-control" id="old_price" name="old_price" value="{{$product->old_price}}">
		</div>
		<div class="form-group">
			<label for="package">Упаковка:</label>
			<input type="text" class="form-control" id="package" name="package" value="{{$product->package}}">
		</div>
		<div class="form-group">
			<label for="quantity">Количество на складе:</label>
			<input type="text" class="form-control" id="quantity" name="quantity" value="{{$product->quantity}}">
		</div>

		<div class="input-group">
		   <span class="input-group-btn">
		     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
		       <i class="fa fa-picture-o"></i> Выбрать изображение
		     </a>
		   </span>
		   <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{$product->img}}">
		 </div>
 		<img src="{{$product->img}}" id="holder" style="margin-top:15px;max-height:100px;">
	 		@if($product->img)
	 			<div class="checkbox">
	 				<label><input type="checkbox" class="remove-img" name="remove">Удалить изображение</label>
	 			</div>
	 		@endif
	 		
 		<div class="form-group">
			<label for="description">Описание:</label>
			<textarea class="form-control" id="description" name="description" >{{$product->description}} </textarea>		
		</div>
		<div class="checkbox">
 			<label><input type="checkbox" name="status" value="{{$product->status}}" {{ $product->status == 1 ? 'checked' : '' }}>Статус (в продаже)</label>
 		</div>
		<div class="checkbox">
 			<label><input type="checkbox" name="hit" value="{{$product->hit}}" {{ $product->hit == 1 ? 'checked' : '' }}>Хит продукт</label>
 		</div>
		<div class="form-group">
			<label for="parentId">Категория:</label>
			<select class="form-control" id="parentId" name="parentId">
				<option value="{{$product->category? $product->category->id : ""}}">{{ $product->category ? $product->category->title : ""}}</option> 
					@foreach($mainCategoriesProvider as $mainCategory)
				        @if($mainCategory->children)
				            @foreach($mainCategory->children as $titleCategory)

				                    @foreach($titleCategory->children as $subCategory)
				                    	<option value="{{$subCategory->id}}">{{$subCategory->title}}</option>
				                    @endforeach
				            @endforeach
				        @endif
				    @endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="parentId">Бренд:</label>
			<select class="form-control" id="brand" name="brand">
				<option value="{{$product->brand? $product->brand->id : ""}}">{{ $product->brand ? $product->brand->title : ""}}</option>
				@foreach($brandsProvider as $brand)
				<option value="{{$brand->id}}">{{$brand->title}}</option>
				@endforeach
			</select>
		</div>

		<button class="btn btn-primary">Сохранить</button>		
	</form>
@stop

@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
 $('#lfm').filemanager('image');
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
 CKEDITOR.replace('description', options);
</script>
@endsection