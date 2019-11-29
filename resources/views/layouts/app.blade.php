<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/owl.theme.default.min.css">

    <!-- Scripts -->
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fpmenu.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/site.css') }}" rel="stylesheet" type="text/css" media="all" />

    @yield('css')
</head>
<body>
    <div id="app">
        <!--top-header-->
        <div class="top-header">
            <div class="container">
                <div class="top-header-main">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <div class="logo-wrapper">
                                <a href="/"><img src="{{asset('images/logo.png')}}" alt="" class="img-fluid"></a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end align-items-center h-100">
                                 <!-- Authentication Links -->
                                @guest
                                    <div class="">
                                        <a class="nav-link" href="{{ route('login') }}">Логин</a>
                                    </div>
                                    @if (Route::has('register'))
                                        <div class="">
                                            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white d-flex align-items-baseline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ Auth::user()->full_name }} <span class="caret"></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                Выйти
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                @csrf
                                            </form>

                                            <a href="/profile/" class="dropdown-item">Мой профиль</a>

                                        </div>
                                    </div>

                                @endguest

                                <div class="cart box_1">
                                     <!-- Button trigger modal -->
                                     <a href="#" data-toggle="modal" data-target="#exampleModal">
                                        <img src="{{ asset('images/cart-1.png') }}" alt="" />
                                    </a>
                                   {{--  @if( session('cart') )
                                        <i class="far fa-circle total-qty"><span>{{session('TotalQty')}}</span></i>                     
                                    @endif --}}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--top-header-->
        <!--start-logo-->
        <div class="logo">
            <a href="/"><h1>Мокрый нос</h1></a>
        </div>

        <!--start-logo-->
        <!--bottom-header-->
        <div class="header-bottom">
            <div class="container">
                <div class="header">
                    <div class="row">
                        <div class="col-md-9 header-left">
                            <div class="top-nav">

                                <ul class="fpmenu springgreen">
                                     <li class="{{request()->is('/') ? 'active' : ''}}"><a href="/">Главная</a></li>
                                     @foreach($mainCategoriesProvider as $mainCategory)
                                        <li class="{{request()->is('category/'.$mainCategory->id) ? 'active' : ''}}">
                                            {{-- <a href="/category/{{$mainCategory->id}}" >{{$mainCategory->title}}</a> --}}
                                            <a href="#">{{$mainCategory->title}}</a>
                                             <div class="fppanel">
                                                <div class="row">
                                                    @if($mainCategory->children)
                                                        @foreach($mainCategory->children as $titleCategory)
                                                        <div class="col fp-one">
                                                            <h4>{{$titleCategory->title}}</h4>
                                                            <ul>
                                                                @foreach($titleCategory->children as $subCategory)
                                                                <li><a href="/category/{{$subCategory->id}}">{{$subCategory->title}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                    <li class="{{request()->is('delivery-details') ? 'active' : ''}}"><a href="/delivery-details">Оплата и доставка</a></li>
                                    <li class="{{request()->is('contacts') ? 'active' : ''}}"><a href="/contacts">Контакты</a></li>
                                </ul>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-3 header-right"> 
                            <div class="search-bar">
                                <form class="form-inline" action="/search">
                                  <input name="s" class="form-control mr-sm-2" type="search" placeholder="Поиск по сайту" aria-label="Поиск по сайту">
                                   <input type="submit" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>

        <!--bottom-header-->

    <main class="py-4">
        @yield('content')
    </main>
    <!--footer-starts-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-wrapper w-100">
                     <div class="col-sm-12 col-md-8">

                        <ul class="social-icons">
                          <li><a class="facebook" href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                          <li><a class="twitter" href="https://twitter.com/?lang=ru" target="_blank"><i class="fab fa-twitter"></i></a></li>
                          <li><a class="instagram" href="https://www.instagram.com/?hl=ru" target="_blank"><i class="fab fa-instagram"></i></a></li> 
                        </ul>

                    </div>
                    <div class="col-sm-12 col-md-4 text-sm-center text-md-right">                 
                        <p class="mb-0">© 2019 Мокрый нос. Все права защищены</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
    <!--footer-end-->   

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- то, что будет выводится в корзине --}}
            @include('web.product.minicart')
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger clear-cart">Очистить корзину</button>
            <a href="/checkout" class="btn btn-success">Оформить заказ</a>
          </div>
        </div>
      </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>

<script src="{{ asset('js/script.js') }}"></script>
<script type="text/javascript">
  // Notice how this gets configured before we load Font Awesome
  window.FontAwesomeConfig = { autoReplaceSvg: false }
</script>
<script src="{{ asset('js/fontawesome.all.min.js') }}"></script>
<!--start-menu-->
<script src="{{ asset('js/fpmenu.js') }}"></script>
<script>$(document).ready(function(){$(".fpmenu").fpmenu();});</script>

@yield('js')
</body>
</html>
