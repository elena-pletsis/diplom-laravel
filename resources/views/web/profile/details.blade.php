@extends('layouts.profile') 

@section('content')
<div class="container">
	@if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@endif

	<div class="row">
		<div class="col-md-10">
			<form action="/profile/edit-profile-details" method="POST">
				<input type="hidden" name="_method" value="PUT">
				{{csrf_field()}}
				{{-- {{dd($user)}} --}}
				<div class="form-group">
					<label for="full_name">Имя фамилия:</label>
					<input type="text" class="form-control" id="full_name" name="full_name" value="{{$user->full_name}}" {{-- readonly="readonly" --}}>
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" {{-- readonly="readonly" --}}>
				</div>
				<div class="form-group">
					<label for="address">Адрес:</label>
					<input type="text" class="form-control" id="address" name="address" value="{{$user->address}}">
				</div>
				<div class="form-group">
					<label for="phone">Телефон:</label>
					<input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}">
				</div>
				<button class="btn btn-save-profile-details">Сохранить</button>
			</form>
		</div>
		<div class="col-md-2"></div>
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

	