@extends('adminlte::page') 

@section('title', $pageTitle)

@section('content_header')
    <h1>{{$pageTitle}}<strong><a href="/product/{{$product->slug}}">{{ $product->title }}</a></strong></h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@if (session('message'))
			    <div class="alert alert-success">
			        {{ session('message') }}
			    </div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="wrapper" style="padding: 15px 15px 10px; color: #b8c7ce;">          
			<div class="col-md-12">
				@foreach($reviews as $review)
				  {{-- {{dd($review->product->slug)}} --}}
				  <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
				    <strong><a href="/admin/review/user/{{$review->user_id}}">{{ $review->user_name }}</a></strong> 
				    <small>{{$review->created_at}}</small>
				  </div>
				  <div class="mt-3">
				    <p class="pl-5 mt-1">{{ $review->review_text }}</p>
				  </div>
				  <hr>
				@endforeach
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-center">{{$reviews->links('vendor.pagination.bootstrap-4')}} </div>
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
