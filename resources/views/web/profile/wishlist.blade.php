@extends('layouts.profile')

@section('content')
<div class="container">
	@if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@endif
  
	 <div class="products"> 
    <div class="container">
      <div class="products-top">
        <div class="row">
          <div class="col-md-9 products-left">
          <div class="product-one row">
            @if($wishlist->isEmpty())
              <div class="empty-wishlist">
                <p>Список пуст. <a href="/#hit-products">Обратите внимание на хиты продаж</a></p>
              </div>
            @else
            @foreach($wishlist as $wish)
              <div class="col-md-4 product-left p-left">
                <div class="product-main simpleCart_shelfItem">

                  <button type="button" class="close delete-wish-product" data-user_id="{{Auth::user()->id}}" data-product_id="{{$wish->product->id}}" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>

                  <a href="/product/{{$wish->product->slug}}" class="mask"><img class="img-fluid zoom-img" src="{{$wish->product->img}}" alt="" /></a>
                  <div class="product-bottom">
                    <h3><a href="/product/{{$wish->product->slug}}">{{$wish->product->title}}</a></h3>

                    <h4>
                      <span class=" item_price">
                      @if($wish->product->old_price)
                          <small><del>{{$wish->product->old_price}}</del></small>
                      @endif
                      {{$wish->product->price}} грн.</span> 
                    </h4>
                  </div>
                  @if($wish->product->old_price)
                      <div class="srch">
                          <span>{{round(($wish->product->old_price - $wish->product->price) *100 / $wish->product->old_price, 0)}}%</span>
                      </div>
                  @endif 
                </div>
              </div>
              @endforeach
              @endif
            <div class="clearfix"></div>            
          </div>
        </div>  
        <div class="clearfix"></div>
        </div>
      </div>
     <div class="d-flex justify-content-center">{{$wishlist->links('vendor.pagination.bootstrap-4')}} </div>
  </div>	
</div>		

@stop

@section('js')
<script>
	(function($){
        $(document).ready(function(){
	        
        });
    })(jQuery);  
</script>

@endsection