@extends('layouts.profile')

@section('content')
<div class="container-fluid">
	<table id="table" class="table table-hover" style="width:100%">
		<thead>
			<tr>
				<th></th>
				<th>Заказ</th>
				<th>Имя фамилия</th>
				<th>Email</th>
				<th>Телефон</th>
				<th>Адрес</th>
				<th>Статус заказа</th>
				<th>Валюта</th>
				<th>Заметки</th>
				<th>Всего</th>
				<th>Сумма к оплате</th>
				<th>Создан</th>
				<th>Обновлён</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($userOrders as $order)
				<tr>
					<td class="details-control"></td>
					<td>{{$order->id}}</td>
					<td>{{$order->full_name}}</td>
					<td>{{$order->email}}</td>
					<td>{{$order->phone}}</td>
					<td>{{$order->address}}</td>
					<td>{{$order->status->name}}</td>
					<td>{{$order->currency}}</td>
					<td>{{$order->note}}</td>
					<td>{{$order->total_sum}}</td>
					<td>{{$order->sum_to_pay}}</td>
					<td>{{$order->created_at}}</td>	
					<td>{{$order->updated_at}}</td>									
				</tr>

			@endforeach		
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th style="padding-left:0"></th>
				<th style="padding-left:0"></th>
				<th></th>
				<th></th>
			</tr>
		</tfoot>
	</table> 

</div>

@stop

@section('js')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>	
	(function($){
        $(document).ready(function(){
// https://datatables.net/blog/2017-03-31 //datatables child rows ajax
	        function format ( rowData ) {
    			var div = $('<div/>')
        			.addClass( 'loading' )
        			.text( 'Loading...' );
 
			    $.ajax( {
			        url: '/admin/order-details',
			        type: "POST",
			        data: {
			           orderId: rowData.Order
			        },
			        dataType: 'json',
			        success: function ( json ) {
			        	console.log(json);
			        	var itemsTable = 
			        	`<table class="table-striped table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
			        		<tr>
								<th>№</th>
								<th>Название</th>
								<th>Цена</th>
								<th>Количество</th>
								<th>Всего к оплате</th>
							</tr>`;
						$.each(json, function (index, item) {
							itemsTable += 
					        `<tr>
								<td>${index+1}</td>
								<td>${item.product_title}</td>
								<td>${item.product_price}</td>
								<td>${item.product_qty}</td>
								<td>${item.product_price*item.product_qty}</td>
							</tr>`
					    });
				 		itemsTable += '</table>';

			            div
			                .html( itemsTable )
			                .removeClass( 'loading' );
			        }
			    } );
 
    			return div;
			}


	        var table = $('#table').DataTable( {
				"searching": false,
		        "columns": [
		            {
		                "className":      'details-control',
		                "orderable":      false,
		                "data":           null,
		                "defaultContent": ''
		            },
		            { "data": "Order" },
		            { "data": "Full name" },
		            { "data": "Email" },
		            { "data": "Phone" },
		            { "data": "Address" },
					{ "data": "Order status" },
					{ "data": "Currency" },
					{ "data": "Note" },
					{ "data": "Total" },
		            { "data": "Sum to pay" },
		            { "data": "Created at" },
		            { "data": "Update at" }
		        ],
		        "order": [[1, 'asc']],

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
						        .column( 9 )
						        .data()
						        .reduce( function (a, b) {
						            return intVal(a) + intVal(b);
						        }, 0 );
						 
						    total1 = api
						        .column( 10 )
						        .data()
						        .reduce( function (a, b) {
						            return intVal(a) + intVal(b);
						        }, 0 );
				 
				            // Update footer
				            $( api.column( 9 ).footer() ).html(
				            	`Total: ${total}`
				            );
				            $( api.column( 10 ).footer() ).html(
				            	`Sum to pay: ${total1}`
				            );
				        },
		    } );

	        			     
		    // Add event listener for opening and closing details
		    $('#table tbody').on('click', 'td.details-control', function () {
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
			
        });
    })(jQuery);  
</script>

@endsection
