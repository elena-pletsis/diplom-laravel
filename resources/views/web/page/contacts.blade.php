@extends('layouts.app')

@section('content')
@include('layouts.errors')
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

  <div class="container">
  <!--contact-start-->
    <div class="contact">
      <div class="contact-top heading">
        <h2>Свяжитесь с нами</h2>
      </div>
        <div class="contact-text">
          <div class="row">
            <div class="col-md-3 contact-left">
              <div class="address">
                <h5>Адрес:</h5>
                <p>Мокрый Нос 
                <span>69063 Украина, г. Запорожье</span>
                пр. Соборный 43</p>
              </div>            
            </div>
              <div class="col-md-9 contact-right">
                <form action="/send-mail" method="POST">
                  {{csrf_field()}}
                  <div class="row">
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" name="full_name" placeholder="Имя фамилия *" required="required">
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" name="phone" placeholder="Номер телефона">
                    </div>  
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" name="email" placeholder="Email *" required="required">
                    </div>  
                  </div>
                  <div class="form-group">
                    <textarea name="message" rows="3" class="form-control" placeholder="Текст сообщения *" required="required"></textarea>
                  </div>
                  <div class="submit-btn">
                    <button type="submit" class="btn submit-contact-form">Отправить</button>
                </form>
              </div>  
              <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
  <!--contact-end-->
  <!--map-start-->
<div class="container-fluid">
  <div class="map">
      {{-- https://www.embedgooglemap.net/ --}}
      <iframe id="gmap_canvas" src="https://maps.google.com/maps?q=%D0%97%D0%B0%D0%BF%D0%BE%D1%80%D0%BE%D0%B6%D1%8C%D0%B5%20%D1%81%D0%BE%D0%B1%D0%BE%D1%80%D0%BD%D1%8B%D0%B9%2043&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
  </div>
</div>
  <!--map-end--> 


@endsection
