@extends('adminlte::page') 

@section('title', $pageTitle)

@section('content_header')
    <h1>{{$pageTitle}}</h1>
@stop

@section('content')
	<table id="table" class="table">
		<thead>
			<tr>
				<th></th>
				<th>Id</th>
				<th>Название</th>
				<th>Изображение</th>
				<th>Родительская категория</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach ($mainCategoriesProvider as $mainCategory)
				<tr class="success">
					<td class="details-control main-category"></td>
					<td>{{$mainCategory->id}}</td>
					<td class="category-title">
						{{$mainCategory->title}}
						<div class="category-edit">
							<a href="/admin/category/{{$mainCategory->id}}/edit" class="btn-link">Редактировать</a>
							<form action="/admin/category/{{$mainCategory->id}}" method="POST">
								<input type="hidden" name="_method" value="DELETE">
								{{csrf_field()}}
								<button class="delete btn-link" style="width: 80px">Удалить</button>
							</form>
						</div>
					</td>
					<td><img src="{{$mainCategory->img}}" alt=""></td>
					<td>{{$mainCategory->parent?$mainCategory->parent->title:""}}</td>
				</tr>
				@foreach($mainCategory->children as $titleCategory)
					<tr>
						<td class="details-control"></td>
						<td>{{$titleCategory->id}}</td>
						<td class="category-title">
							{{$titleCategory->title}}
							<div class="category-edit">
								<a href="/admin/category/{{$titleCategory->id}}/edit" class="btn-link">Редактировать</a>
								<form action="/admin/category/{{$titleCategory->id}}" method="POST">
									<input type="hidden" name="_method" value="DELETE">
									{{csrf_field()}}
									<button class="delete btn-link" style="width: 80px">Удалить</button>
								</form>
							</div>
						</td>
						<td class="text-center"><img src="{{$titleCategory->img}}" alt="" style="width: 80px; height: 80px;"></td>
						<td>{{$titleCategory->parent?$titleCategory->parent->title:""}}</td>
					</tr>
					@endforeach
			@endforeach		
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>				
			</tr>
		</tfoot>
	</table> 

@stop

@section('js')
<script>
	(function($){
        $(document).ready(function(){
// https://datatables.net/blog/2017-03-31 //datatables child rows ajax
	        function format ( rowData ) {
	        	// console.log(rowData);
    			var div = $('<div/>')
        			.addClass( 'loading' )
        			.text( 'Loading...' );
 
			    $.ajax( {
			        url: '/admin/title-categories',
			        type: "POST",
			        data: {
			        	categoryId: rowData.Id
			        },
			        dataType: 'json',
			        success: function ( json ) {
			        	// console.log(json);
			        	var subCategoryTable = 
			        	`<table class="dataTable inner-table table">`;			
						$.each(json, function (index, titleCategory) {

							//dd($cat);
							subCategoryTable += 
					        `<tr>
					        <td class="success"></td>
					        <td class="success">${titleCategory.id}</td>
							<td class="category-title success">${titleCategory.title}
								<div class="category-edit">
									<a href="/admin/category/${titleCategory.id}/edit" class="btn-link">Edit</a>
									<form action="/admin/category/${titleCategory.id}" method="POST">
										<input type="hidden" name="_method" value="DELETE">
										{{csrf_field()}}
										<button class="delete btn-link" style="width: 80px">Delete</button>
									</form>
								</div>
							</td>
							<td class="success"><img src="${titleCategory.img}" alt="" style="width: 80px; height: 80px;"></td>
							<td class="success"></td>						
							</tr>`
					    });

				 		subCategoryTable += '</table>';

			            div
			                .html( subCategoryTable )
			                .removeClass( 'loading' );
			        }
			    } );
 
    			return div;
			}


	        var table = $('#table').DataTable( {

	        	"drawCallback": function( settings ) {
        			$( ".category-title" )
			  		.on( "mouseenter", function() {
			  			$(this).find('.category-edit').addClass('visible');
					})
					.on( "mouseleave", function() {
			  			$(this).find('.category-edit').removeClass('visible');
					});
    			},

		        "columns": [
		            {
		                "className":      'details-control',
		                "orderable":      false,
		                "data":           null,
		                "defaultContent": ''
		            },
		            
		            { "data": "Id" },
		            { "data": "Title" },
		            { "data": "Img" },
		            { "data": "Parent category" }
		        ],
		        "order": []
		        // "order": [[1, 'asc']],	   

		    } );
			     
		    // Add event listener for opening and closing details
		    $('#table tbody').on('click', 'td.details-control', function () {
		    	if ($(this).hasClass('main-category'))
		    		return;
		        var tr = $(this).closest('tr');
		        var row = table.row( tr );

		        if ( row.child.isShown() ) {
		            // This row is already open - close it
		            row.child.hide();
		            tr.removeClass('shown');
		        }
		        else {
		            // Open this row
		            row.child( format(row.data()) ).show();
		            tr.addClass('shown');
		        }
		    } );

		    $('body').on('mouseenter', '.inner-table td.category-title', function () {
		    	$(this).find('.category-edit').addClass('visible');
		    } );

		    $('body').on('mouseleave', '.inner-table td.category-title', function () {
		    	$(this).find('.category-edit').removeClass('visible');
		    } );

        });
    })(jQuery);  
</script>

@endsection








{{--/* @extends('adminlte::page') 

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
				<th>Id</th>
				<th>Parent id</th>
				<th>Title</th>
				<th>IMG</th>
				<th>Parent Category</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($categories as $category)
				<tr>
					<td>{{$category->id}}</td>
					<td>{{$category->parent_id}}</td>
					<td class="category-title">
						{{$category->title}}
						<div class="category-edit">
							<a href="/admin/category/{{$category->id}}/edit" class="btn-link">Edit</a>
							<form action="/admin/category/{{$category->id}}" method="POST">
								<input type="hidden" name="_method" value="DELETE">
								{{csrf_field()}}
								<button class="delete btn-link" style="width: 80px">Delete</button>
							</form>
						</div>
					</td>
					<td><img src="{{$category->img}}" alt="" style="width: 100px"></td>
					<td>{{$category->parent?$category->parent->title:""}}</td>
				{{-</tr>

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
        			$( ".category-title" )
			  		.on( "mouseenter", function() {
			  			$(this).find('.category-edit').addClass('visible');
					})
					.on( "mouseleave", function() {
			  			$(this).find('.category-edit').removeClass('visible');
					});
    			}
	        });
        });
    })(jQuery);  
</script>
 --}}
{{-- @endsection --}}
 