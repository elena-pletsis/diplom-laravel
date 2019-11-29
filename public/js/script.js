//alert(123)
(function($){
	$(document).ready(function(){

		
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('.add-to-cart').submit(function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '/add-to-cart',
				data: $(this).serialize(),
				success: function(result){
					showCart(result);
				}
			});
		});

		$('.add-to-cart-link').click(function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '/add-to-cart',
				data: {
					id: $(this).data('id'),
					qty: 1
				},
				success: function(result){
					showCart(result);
				}
			});
		});

		function showCart(result) {
			$('#exampleModal .modal-body').html(result);
			$('#exampleModal').modal();
		}

		$('.clear-cart').click(function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '/clear-cart',
				success: function(result){
					showCart(result);
				}
			});
		});

		// $('body').on( 'click', '.remove-product', function () {
        $('#exampleModal').on( 'click', '.remove-product', function () {
			$.ajax({
				type: 'POST',
				url: '/clear-one',
				data:{
					id: $(this).data('id')
				},
				success: function(result){
					showCart(result);
					
				}
			});
		} );

        $('#exampleModal').on( 'click', '.button-minus-product', function (){
        	if($(this).next().val() > 1){
				$.ajax({
					type: 'POST',
					url: '/minus-cart-product',
					data:{
						id: $(this).closest('div').data('id')
					},
					success: function(result){
						showCart(result);
										
					}
				});
			} 
			else {
				$(this).attr('disabled', true);
			}
			
		});

		$('#exampleModal').on( 'click', '.button-plus-product', function (){

			if ($(this).prev().val() === $(this).prev().attr('max')) {
				$(this).attr('disabled', true);
				return;
			}

			$.ajax({
				type: 'POST',
				url: '/plus-cart-product',
				data:{
					id: $(this).closest('div').data('id')
				},
				success: function(result){
					showCart(result);					
				}
			});
		});

		$('.wish-list').click(function(e){
			e.preventDefault();
			let elem = $(this);
			$.ajax({
				type: 'POST',
				url: '/profile/wishlist',
				data: {
					user_id: $(elem).data('user_id'),
					product_id: $(elem).data('product_id')
				}, 
				success: function(result){
					//console.log(result);
					if(result === 'deleted'){
						$(elem).find('i').removeClass('fas').addClass('far');
						$(elem).find('span').removeClass("hidden");						
					} else {
						$(elem).find('i').removeClass('far').addClass('fas');
						$(elem).find('span').addClass("hidden");
					}

				}
			});
		});

		 $('#sidebarCollapse').on('click', function () {
        	$('#sidebar').toggleClass('active');
        	if($('#sidebar').hasClass('active')){
				$(this).find('span').text('Развернуть');	
			} else {
				$(this).find('span').text('Свернуть');
			}

		});

		 $('.delete-wish-product').click(function(){
			let elem = $(this); //eлемент по которому кликнули
			$.ajax({
				type: 'POST',
				url: '/profile/delete-product',
				data: {
					user_id: $(elem).data('user_id'),
					product_id: $(elem).data('product_id')
				}, 
				success: function(result){
					if(result){
						elem.closest('.product-left').remove();
					}
				}
			});
		});


	});
})(jQuery);

