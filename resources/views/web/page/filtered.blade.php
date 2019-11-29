@extends('layouts.app')

@section('content')
    <!--products-starts-->
    {{-- {{dd($products)}} --}}
  <div class="products"> 
    <div class="container">
      <div class="products-top">
        <div class="row">          
          <div class="col-md-9 products-left">
            @if($filteredProducts->isNotEmpty())
              <div class="product-one row">
                @foreach($filteredProducts as $product)
                  <div class="col-md-4 product-left p-left">
                    <div class="product-main simpleCart_shelfItem">
                      <a href="/product/{{$product->slug}}" class="mask"><img class="img-fluid zoom-img" src="{{$product->img}}" alt="" /></a>
                      <div class="product-bottom">
                        <h3><a href="/product/{{$product->slug}}">{{$product->title}}</a></h3>
                        <h4>
                          <a class="add-to-cart-link" href="#" data-id="{{$product->id}}"><i class="fas fa-cart-plus"></i></a>
                          <span class="item_price">
                            @if($product->old_price)
                              <small><del>{{$product->old_price}}</del></small>
                          @endif
                          {{$product->price}} грн.</span>                               
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
              <div class="clearfix"></div>            
              </div>
            @else                
              <h4>Поиск не дал результатов</h4>
            @endif
          </div>  
          <div class="col-md-3 products-right">
            <div class="w_sidebar">
              <form action="/filtered-products" method="GET">
                {{csrf_field()}}
                <input type="hidden" name="titleCategory" value="{{$titleCategory->id}}">
                <section class="sky-form">
                  <h4>Категории</h4>
                  <div class="row1 scroll-pane">
                    <div class="col">
                      {{-- {{dd($titleCategory->children)}} --}}
                      <label><i></i>{{$titleCategory->title}}</label>
                    </div>
                    <div class="col">               
                      @foreach($titleCategory->children as $category)
                        <label class="checkbox"><input type="checkbox" name="category[]" value="{{$category->id}}" {{ $categories && in_array($category->id, $categories) ? 'checked' : '' }}><i></i>{{$category->title}}</label>
                      @endforeach
                    </div>
                  </div>
                </section>
                <section  class="sky-form">
                  <h4>Бренды</h4>
                  <div class="row1 row2 scroll-pane">
                    <div class="col">
                      @foreach($brandsProvider as $brand)
                        <label class="checkbox"><input type="checkbox" name="brand[]" value="{{$brand->id}}" {{ $brands && in_array($brand->id, $brands) ? 'checked' : '' }}><i></i>{{$brand->title}}</label>
                      @endforeach                     
                      
                    </div>
                  </div>
                </section>
                <section class="sky-form">
                  <h4>Цена</h4>
                  <div class="row no-gutters prices-wrapper">
                    <div class="col-sm-6 d-flex justify-content-center">
                      <input type="text" class="price-filter" name="price_from" placeholder="От" value="{{$price_from ? $price_from : 0}}">
                    </div>
                    <div class="col-sm-6 d-flex justify-content-center">
                      <input type="text" class="price-filter" name="price_to" placeholder="До" value="{{$price_to ? $price_to : 50000}}">
                    </div>
                  </div>
                </section>

                <button type="submit" class="btn filters-button">Применить фильтры</button>
              </form>
            </div>
          </div>
          <div class="clearfix"></div>

        </div>
      </div>
    </div>
     <div class="d-flex justify-content-center">{{$filteredProducts->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')}} </div>
  </div>
  <!--product-end-->

@endsection
