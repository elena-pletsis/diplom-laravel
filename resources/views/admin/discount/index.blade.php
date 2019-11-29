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
				<th>Скидка</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($discount as $disc)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td class="disc-name">
						{{$disc->title}}
						<div class="disc-edit">
							<a href="/admin/discount/{{$disc->id}}/edit" class="btn-link">Редактировать</a>
							<form action="/admin/discount/{{$disc->id}}" method="POST">
								<input type="hidden" name="_method" value="DELETE">
								{{csrf_field()}}
								<button class="delete btn-link" style="width: 80px">Удалить</button>
							</form>
						</div>
					</td>
					<td>{{$disc->percent}}</td>
					
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
        			$( ".disc-name" )
			  		.on( "mouseenter", function() {
			  			$(this).find('.disc-edit').addClass('visible');
					})
					.on( "mouseleave", function() {
			  			$(this).find('.disc-edit').removeClass('visible');
					});
    			}
	        });
        });
    })(jQuery);  
</script>

@endsection

	