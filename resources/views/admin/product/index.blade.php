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
				<th>id товара</th>
				<th>Название:</th>
				<th>Изображение:</th>
{{-- 				<th>Слаг:</th> --}}
{{-- 				<th>Описание:</th> --}}
				<th>Цена:</th>
				<th>Старая цена:</th>
				<th>Упаковка:</th>
				<th>Количество на складе:</th>
				<th>Статус (в продаже):</th>
				<th>Хит продукт:</th>				
				<th>Категория:</th>
				<th>Бренд:</th>

			</tr>
		</thead>
		<tbody>
			@foreach ($products as $product)
				<tr data-id="{{$product->id}}">
					<td>{{$product->id}}</td>

					<td class="product-title">
						{{$product->title}}
						<div class="product-edit">
							<a href="/admin/product/{{$product->id}}/edit" class="btn-link">Редактировать</a>
							<a href="#" class="btn-link delete-product">Удалить</a>
						</div>
					</td>
					<td style="text-align: center;"><img src="{{$product->img}}" alt="" style="max-width: 100%; max-height: 100px;"></td>
{{-- 					<td>{{$product->slug}}</td> --}}
{{-- 					<td>{!! $product->description !!}</td> --}}
					<td>{{$product->price}}</td>
					<td>{{$product->old_price}}</td>
					<td>{{$product->package}}</td>
					<td>{{$product->quantity}}</td>
					<td>

						<i class="edit-status fa-lg fa fa-chevron-down {{$product->status ? 'text-success' : 'text-danger'}}"></i>	
					</td>					
					<td>
						<i class="edit-hit fa-lg fa fa-chevron-down {{$product->hit ? 'text-success' : 'text-danger'}}"></i>	
					</td>
					<td>{{$product->category ? $product->category->title : ""}}</td>
					<td>{{$product->brand ? $product->brand->title : ""}}</td>
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
	        	
	        	//устанавливает свойства инициализации определения столбца
	        	// https://datatables.net/reference/option/columns.className - присваиваем класс для 3 столбца
	        	"columnDefs": [
    				{ className: "price", "targets": [ 3 ] } 
  				],
  				// drawCallback, функция, которая вызывается каждый раз, когда DataTables выполняет отрисовку.
	        	 "drawCallback": function( settings ) {
        			$( ".product-title" )
			  		.on( "mouseenter", function() {
			  			$(this).find('.product-edit').addClass('visible');
					})
					.on( "mouseleave", function() {
			  			$(this).find('.product-edit').removeClass('visible');
					});
    			}
	        });
//https://datatables.net/forums/discussion/48593/how-do-i-make-td-element-editable-on-double-click
	        $('#table tbody').on( 'dblclick', '.price', function () {
				console.log($( this ).text());
				newInput(this);
			} );


			function newInput(elm) { 
               var value = $(elm).text();
               $(elm).empty();
 
               $("<input>")
                   .attr('type', 'text')
                   .val(value)
                   .blur(function () {
                       closeInput(elm);
                   })
                   .appendTo($(elm))
                   .focus();
           }
            
            function closeInput(elm) {
               var value = $(elm).find('input').val();
               $(elm).empty().text(value);
				$.ajax({
					type: 'POST',
					url: '/admin/update-price',
					data:{
						id: $(elm).closest('tr').data('id'),
						newPrice: value
					},
					success: function(result){
						console.log(123);
					}
				});

           }
        });
    })(jQuery);  
</script>

@endsection


