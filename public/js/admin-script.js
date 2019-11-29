//alert(123)
(function($){
	$(function(){
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('.edit-hit').click(function(){
			let elem = $(this); //элемент по которому кликнули
			$.ajax({
				type: 'POST',
				url: '/admin/edit-hit',
				data:{
					id: elem.closest('tr').data('id')
				},
				success: function(result){
					if(result){
						elem.toggleClass('text-success text-danger');
					}
				}
			});
		});

		$('.edit-status').click(function(){
			let elem = $(this); //лемент по которомц кликнули
			$.ajax({
				type: 'POST',
				url: '/admin/edit-status',
				data:{
					id: elem.closest('tr').data('id')
				},
				success: function(result){
					if(result){
						elem.toggleClass('text-success text-danger');
					}
				}
			});
		});

		$('.edit-club-member').click(function(){
			let elem = $(this); //элемент по которому кликнули
			$.ajax({
				type: 'POST',
				url: '/admin/edit-club-member',
				data:{
					id: elem.closest('tr').data('id')
				},
				success: function(result){
					if(result){
						elem.toggleClass('text-success text-danger');
					}
				}
			});
		});

		$('.remove-img').click(function(){
			if( $(this).prop('checked') ){
				$('#thumbnail').val('');
				$('#holder').attr('src', '');
			}
		});

		$('.delete-product').click(function(){
			let elem = $(this); //eлемент по которому кликнули
			$.ajax({
				type: 'POST',
				url: '/admin/delete-product',
				data:{
					id: elem.closest('tr').data('id')
				},
				success: function(result){
					//console.log(result);
					if(result){
						elem.closest('tr').remove();
					}
				}
			});
		});

		

	});
})(jQuery);

