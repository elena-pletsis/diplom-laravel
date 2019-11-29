@extends('layouts.profile')

@section('content')
<div class="container">
	@if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@endif

    <div class="row">          
      <div class="col-md-10 mt-4 reviews-wrapper">
        @foreach($reviews as $review)
          <div class="d-flex justify-content-between">
            <strong><a href="/product/{{$review->product->slug}}">{{ $review->product->title }}</a></strong>
            <small>{{$review->created_at}}</small>
          </div>
          <div class="mt-3">
            <p class="pl-5 mt-1">{{ $review->review_text }}</p>
          </div>
          <hr>
        @endforeach
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="d-flex justify-content-center">{{$reviews->links('vendor.pagination.bootstrap-4')}} </div>	

@stop

@section('js')
<script>
	(function($){
        $(document).ready(function(){
	        
        });
    })(jQuery);  
</script>

@endsection