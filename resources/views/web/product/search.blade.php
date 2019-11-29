@extends('layouts.app')

@section('content')
    <!--products-starts-->
  <div class="products"> 
    <div class="container">
      <div class="products-top">
        <div class="row">          
          <div class="col-md-12 products-left">
          @if($searchProducts->isNotEmpty())
          <div class="product-one row">            
            @foreach($searchProducts as $product)
              <div class="col-md-4 product-left p-left">
                <div class="product-main simpleCart_shelfItem">
                  <a href="/product/{{$product->slug}}" class="mask"><img class="img-fluid zoom-img" src="{{$product->img}}" alt="" /></a>
                  <div class="product-bottom">
                    <h3><a href="/product/{{$product->slug}}">{{$product->title}}</a></h3>
                    <h4>
                      <a class="add-to-cart-link" href="#" data-id="{{$product->id}}"><i class="fas fa-cart-plus"></i></a>
                      <span class=" item_price">$ {{$product->price}}</span>
                      @if($product->old_price)
                          <small><del>{{$product->old_price}}</del></small>
                      @endif                                 
                    </h4>
                    @if (Auth::user()) 
                      {{-- ajax wishlist--}}
                      @if($wishProductsProvider->contains('product_id', $product->id))
                          <a href="" class="wish-list" data-user_id="{{Auth::user()->id}}" data-product_id="{{$product->id}}"> <i class="fa-lg fas fa-heart"></i><span class="hidden">Добавить в список желаний</span></a> 
                      @else
                          <a href="" class="wish-list" data-user_id="{{Auth::user()->id}}" data-product_id="{{$product->id}}"> <i class="fa-lg far fa-heart"></i><span>Добавить в список желаний</span></a> 
                      @endif
                    @endif
                  </div>
                  @if($product->old_price)
                      <div class="srch">
                          <span>{{round(($product->old_price-$product->price)*100/$product->old_price, 0)}}%</span>
                      </div>
                  @endif 
                </div>
              </div>
              @endforeach
              @else                
                <h4>Поиск не дал результатов</h4>
              @endif
            <div class="clearfix"></div>            
          </div>
        </div>
      </div>
    </div>
    </div>
     <div class="d-flex justify-content-center">{{$searchProducts->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')}} </div>
  </div>
  <!--product-end-->
@endsection




