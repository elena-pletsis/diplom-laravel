@extends('layouts.app')


@section('content')

<div class="container">
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>

<!--banner-starts-->
    <div class="bnr" id="home">
        <div  id="top" class="callbacks_container">
            <ul class="rslides" id="slider4">
                <li>
                    <img src="images/home-slider/img_1.png" alt=""/>
                </li>
                <li>
                    <img src="images/home-slider/img_2.png" alt=""/>
                </li>
                <li>
                    <img src="images/home-slider/img_3.png" alt=""/>
                </li>
                 <li>
                    <img src="images/home-slider/img_4.png" alt=""/>
                </li>
                 <li>
                    <img src="images/home-slider/img_5.png" alt=""/>
                </li>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
    <!--banner-ends--> 

    <!--about-starts-->
    @if($brands)
    <div class="about"> 
        <div class="container">
            <div class="about-top grid-1">
                <div class="row">
                    <div class="owl-carousel">
                        @foreach($brands as $brand)
                        <div class="about-left">
                            <figure class="effect-bubba">
                                <a href="/brand/{{$brand->id}}">
                                    <img class="img-fluid" src="{{$brand->img}}" alt=""/>
                                    <figcaption>                                    
                                        <h2>{{$brand->title}}</h2>{{-- {{$brand->title}} --}}
                                    </figcaption>
                                </a>           
                            </figure>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @endif
    <!--about-end-->
    <!--product-starts-->
    @if($hits)
    <div id="hit-products" class="product"> 
        <div class="container">
            <div class="product-top">
                <div class="product-one">                    
                    <div class="row">
                        @foreach($hits as $hit)
                            <div class="col-md-3 product-left">
                                <div class="product-main simpleCart_shelfItem">
                                    <a href="/product/{{$hit->slug}}" class="mask"><img class="img-fluid zoom-img" src="{{$hit->img}}" alt="" /></a>
                                    <div class="product-bottom">
                                        <h3><a href="/product/{{$hit->slug}}">{{$hit->title}}</a></h3>
                                        <div class="product-price">
                                             <h4>
                                                <a class="add-to-cart-link" href="#" data-id="{{$hit->id}}"><i class="fas fa-cart-plus"></i></a>
                                                {{-- href="cart/add?id-{{$hit->id}}" --}}
                                                <span class="item_price">
                                                @if($hit->old_price)
                                                    <small><del>{{$hit->old_price}}</del></small>
                                                @endif
                                                {{$hit->price}} грн.</span>   
                                            </h4>

                                             @if (Auth::user()) 
                                                {{-- ajax wishlist--}}
                                                @if($wishProductsProvider->contains('product_id', $hit->id))
                                                    <a href="" class="wish-list" data-user_id="{{Auth::user()->id}}" data-product_id="{{$hit->id}}"> <i class="fa-lg fas fa-heart"></i><span class="hidden">Добавить в список желаний</span></a>
                                                @else
                                                    <a href="" class="wish-list" data-user_id="{{Auth::user()->id}}" data-product_id="{{$hit->id}}"> <i class="fa-lg far fa-heart"></i><span>Добавить в список желаний</span></a> 
                                                @endif
                                             @endif   

                                            </div>
                                        </div>
                                        @if($hit->old_price)
                                            <div class="srch">
                                                <span>{{round(($hit->old_price-$hit->price)*100/$hit->old_price, 0)}}%</span>
                                            </div>
                                        @endif 
                                </div>
                            </div>
                        @endforeach                         
                    </div>                   
                    <div class="clearfix"></div>
                </div>
            </div>                  
        </div>
    </div>
    @endif
    <!--product-end-->




@endsection

@section('js')
<script>
    (function($){
        $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            nav:true,
            margin: 10,
            loop: true,
            responsiveClass:true,
            navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            responsive:{
                0:{
                    items:2,
                    nav: false,
                },
                600:{
                    items:4,
                },
                1000:{
                    items:6,
                }
            }
        });
        });
    })(jQuery);    
</script>
{{-- http://responsiveslides.com/ --}}
<!--Slider-Starts-Here-->
    <script src="js/responsiveslides.min.js"></script>
     <script>
        $(function () {
          $("#slider4").responsiveSlides({
            auto: true, // Boolean: Animate automatically, true or false
            pager: true, // Boolean: Show pager, true or false
            speed: 500, // Integer: Speed of the transition, in milliseconds
            namespace: "callbacks"
          });
    
        });
      </script>
<!--End-slider-script-->

@endsection
