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
				<th>№</th>
				<th>Название</th>
				<th>Изображение</th>
				<th>Описание</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($brands as $brand)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td class="brand-title">
						{{$brand->title}}
						<div class="brand-edit">
							<a href="/admin/brand/{{$brand->id}}/edit" class="btn-link">Редактировать</a>
							<form action="/admin/brand/{{$brand->id}}" method="POST">
								<input type="hidden" name="_method" value="DELETE">
								{{csrf_field()}}
								<button class="delete btn-link" style="width: 80px">Удалить</button>
							</form>
						</div>
					</td>
					<td><img src="{{$brand->img}}" alt="" style="width: 100px"></td>
					<td>{{$brand->description}}</td>
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
	        	 "drawCallback": function( settings ) {
        			$( ".brand-title" )
			  		.on( "mouseenter", function() {
			  			$(this).find('.brand-edit').addClass('visible');
					})
					.on( "mouseleave", function() {
			  			$(this).find('.brand-edit').removeClass('visible');
					});
    			}
	        });
        });
    })(jQuery);  
</script>

@endsection
	