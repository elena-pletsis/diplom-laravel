@extends('layouts.app')

@section('css')
  <!-- FlexSlider -->
  <link rel="stylesheet" href="{{ asset('css/flexslider.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('css/drift-basic.css') }}" type="text/css" />
@endsection

@section('content')

<!--start-single-->
<div class="single contact">
  <div class="container">
    @if (session('message'))
      <div class="alert alert-success">
        {{ session('message') }}
     </div>
    @endif
    <div class="single-main">
    <div class="row">   
      <div class="col-md-12 single-main-left">
        <div class="sngl-top">
          <div class="row">
            
            <div class="col-md-5 single-top-left">  
              <div class="thumb-image"> <img src="{{$product->img}}" data-zoom="{{$product->img}}" class="img-fluid thumb" alt=""/> </div>            
              <div class="detail"></div>  {{-- отображается увеличенное изображение --}}
            </div>  
            <div class="col-md-7 single-top-right">
              <div class="single-para simpleCart_shelfItem">
                <h2>{{$product->title}}</h2> 
                <h5><span class="item_price">
                  @if($product->old_price)
                      <small><del>{{$product->old_price}}</del></small>
                  @endif
                  {{$product->price}} грн.
                </span></h5>


                <p>
                  @if(strlen($product->description) > 200)
                    {!! trim(substr($product->description,0,200)) !!}
                    <span class="read-more-show">Подробнее</span>
                    <span class="read-more-content">{!! trim(substr($product->description,200,strlen($product->description))) !!} 
                    <span class="read-more-hide hide-product-content">Свернуть</span> </span>
                  @else
                    {{$product->description}}
                  @endif
                </p>                
                 @if($product->quantity)
                  Товара в наличии: {{$product->quantity}}
                  <form action="" class="add-to-cart">
                    <div class="form-group">
                     <label for="qty">Количество</label>
                     <input type="number" name="qty" id="qty" value="1" class="form-control" min="1" max="{{$product->quantity}}">
                    </div>
                    <input type="hidden" name="id" value="{{$product->id}}"> 
                    <button class="btn btn-block add-cart">Добавить в корзину</button>
                  </form>
                 @else Нет в наличии
                @endif
                
              </div>
            </div>
            <div class="clearfix"> </div>

          </div>
          </div>
          <div class="tabs">
            <ul class="menu_drop">
              <li class="item"><a href="#"><img src="{{ asset('images/arrow.png') }}" alt="">Отзывы ({{$productReview->count()}})</a>
                <ul>
                  <li>
                    <div class="row d-flex justify-content-start"> 
                      @if($productReview->isEmpty())
                      <div class="col-12 d-flex justify-content-center mt-2">
                        <h5>Пока нет отзывов</h5>
                      </div>
                      @else
                        @foreach($productReview as $review)
                              <div class="col-12">
                                <div class="subitem-wrapper">
                                  <strong>{{ $review->user_name }}</strong><br>
                                  <p class="pl-5 mt-1">{{ $review->review_text }}</p><hr>
                                </div>
                            </div>
                        @endforeach
                      @endif
                    </div>
                  </li>
                </ul>
              </li>
              <li class="item"><a href="#"><img src="{{ asset('images/arrow.png') }}" alt="">Оставить отзыв</a>
                <ul>
                  <li class="subitem-wrapper">
                    <form action="/add-review" method="POST" class="add-review">
                      <input type="hidden" name="productId" value="{{$product->id}}">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label for="review_text">Отзыв:</label>
                        <textarea id="review_text" name="review_text" class="form-control" required="required"></textarea>
                      </div>
                      <button class="btn btn-block btn-add-review">Сохранить</button> 
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div>

          @if(!$relatedProducts->isEmpty())
            <div class="latestproducts">
              <div class="product-one">
                <div>
                  <h3>Вас может также заинтересовать:</h3>
                </div>
                <div class="row">

                  @foreach($relatedProducts as $relproduct)
                      <div class="col-md-4 product-left">
                          <div class="product-main simpleCart_shelfItem">
                              <a href="/product/{{$relproduct->slug}}" class="mask"><img class="img-fluid zoom-img" src="{{$relproduct->img}}" alt="" /></a>
                              <div class="product-bottom">
                                  <h3><a href="/product/{{$relproduct->slug}}">{{$relproduct->title}}</a></h3>
                                  <h4>
                                      <a class="add-to-cart-link" href="#" data-id="{{$relproduct->id}}"><i class="fas fa-cart-plus"></i></a>
                                      <span class="item_price">
                                        @if($product->old_price)
                                            <small><del>{{$relproduct->old_price}}</del></small>
                                        @endif
                                        {{$relproduct->price}} грн.
                                      </span>
                                  </h4>

                                   @if (Auth::user())                                                               
                                                    {{-- ajax wishlist--}}
                                    @if($wishProductsProvider->contains('product_id', $relproduct->id))
                                      <a href="" class="wish-list" data-user_id="{{Auth::user()->id}}" data-product_id="{{$relproduct->id}}"> <i class="fa-lg fas fa-heart"></i><span class="hidden">Добавить в список желаний</span></a>
                                    @else
                                      <a href="" class="wish-list" data-user_id="{{Auth::user()->id}}" data-product_id="{{$relproduct->id}}"> <i class="fa-lg far fa-heart"></i><span>Добавить в список желаний</span></a> 
                                    @endif 
                                  @endif 
                         
                              </div>
                              @if($relproduct->old_price)
                                  <div class="srch">
                                      <span>{{round(($relproduct->old_price-$relproduct->price)*100/$relproduct->old_price, 0)}}%</span>
                                  </div>
                              @endif 
                          </div>
                      </div>
                  @endforeach       
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            @endif

        </div>
      </div>
    </div>
  </div>
</div>
<!--end-single-->

@endsection

@section('js')
<script src="{{ asset('js/Drift.js') }}"></script> {{-- zoom --}}
<script>
    (function($){
      $(document).ready(function(){
          var menu_ul = $('.menu_drop > li > ul'),
             menu_a  = $('.menu_drop > li > a');      
          menu_ul.hide();  
          menu_a.click(function(e) {
              e.preventDefault();
              if(!$(this).hasClass('active')) {
                  menu_a.removeClass('active');
                  menu_ul.filter(':visible').slideUp('normal');
                  $(this).addClass('active').next().stop(true,true).slideDown('normal');
              } else {
                  $(this).removeClass('active');
                  $(this).next().stop(true,true).slideUp('normal');
              }
          });

          $('.read-more-content').addClass('hide-product-content')
          $('.read-more-show').on('click', function(e) {
            e.preventDefault();
            $('.read-more-content').removeClass('hide-product-content');
            $('.read-more-hide').removeClass('hide-product-content');
            $(this).addClass('hide-product-content');
          });
          $('.read-more-hide').on('click', function(e) {
            e.preventDefault();
            $('.read-more-content').addClass('hide-product-content');
            $('.read-more-show').removeClass('hide-product-content');
            $(this).addClass('hide-product-content');
          });
      });
    })(jQuery);    
</script>
<script>
  var thumbs = document.querySelectorAll('.thumb');
  var detail = document.querySelector('.detail');

  for (var i = 0, len = thumbs.length; i < len; i++) {
    var thumb = thumbs[i];
    
    new Drift(thumb, {
      paneContainer: detail
    });
  }
</script>

@endsection


