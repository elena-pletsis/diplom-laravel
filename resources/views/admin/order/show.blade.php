@extends('adminlte::page') 

@section('title', $pageTitle)

@section('content_header')
    <h1>{{$pageTitle}}</h1>
@stop

@section('content')
	    <div style="display:none" class="alert alert-success orderStatusAlert">
	        
	    </div>	
<div class="row">
	<div class="form-group col-md-4">
			<label for="orderStatus">Статус заказа:</label>
			<select class="form-control" id="orderStatus" name="orderStatus">
				@foreach($statuses as $status)
					<option value="{{$status->id}}" {{($status->name == $currentStatus) ? 'selected' : ''}}>{{$status->name}}</option>
				@endforeach
			</select>
		</div>
</div>
	<table id="table">
		<thead>
			<tr>
				<th>№</th>
				<th>Название</th>
				<th>Цена</th>
				<th>Количество</th>
				<th>Сумма к уплате</th>				
			</tr>
		</thead>
		<tbody>
			@foreach ($orderItems as $item)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$item->product_title}}</td>
					<td>{{$item->product_price}}</td>
					<td>{{$item->product_qty}}</td>
					<td>{{$item->product_qty*$item->product_price}}</td>
				</tr>
			@endforeach	
			
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th style="padding-left:0"></th>
			</tr>
		</tfoot>
	</table> 

@stop

@section('js')
<script>
	(function($){
        $(document).ready(function(){
	        $('#table').DataTable({
	        	"footerCallback": function ( row, data, start, end, display ) {
				            var api = this.api(), data;
				 
				            // Remove the formatting to get integer data for summation
				            var intVal = function ( i ) {
				                return typeof i === 'string' ?
				                    i.replace(/[\$,]/g, '')*1 :
				                    typeof i === 'number' ?
				                        i : 0;
				            };
				 
				            // Total over all pages
				            total = api
				                .column( 4 )
				                .data()
				                .reduce( function (a, b) {
				                    return intVal(a) + intVal(b);
				                }, 0 );
				 
				            // Total over this page
				            // pageTotal = api
				            //     .column( 4, { page: 'current'} )
				            //     .data()
				            //     .reduce( function (a, b) {
				            //         return intVal(a) + intVal(b);
				            //     }, 0 );
				 
				            // Update footer
				            $( api.column( 4 ).footer() ).html(
				            	`Total Sum: ${total}`
				            	//'$'+Total Sum: +' ( $'+ total +' total)'
				                // '$'+pageTotal +' ( $'+ total +' total)'
				            );
				        }
	        });

		    $('#orderStatus').change(function(){
				//console.log(77777);
				$.ajax({
					type: 'POST',
					url: '/admin/order-status',
					data:{
						statusId: $('#orderStatus').val(), 
						orderId: {{$order->id}}
					},
					success: function message(result){
						$('.orderStatusAlert').attr('style', 'display:block').text('Order status changed to "' + $('#orderStatus option:selected').text() + '"');
						//console.log(result);
					}
				});
			});

        });
    })(jQuery);  
</script>

@endsection
