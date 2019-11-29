@extends('layouts.profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Сменить пароль</div>

                <div class="card-body">

                    <form method="POST" action="/profile/updatePassword">
                        @csrf

                        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

                        <div class="form-group row">
                            <label for="currentPassword" class="col-md-4 col-form-label text-md-right">Текущий пароль</label>

                            <div class="col-md-6">
                                <input id="currentPassword" type="password" class="form-control @error('currentPassword') is-invalid @enderror" name="currentPassword" required>

                                @error('currentPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="newPassword" class="col-md-4 col-form-label text-md-right">Новый пароль</label>
							{{-- https://stackoverflow.com/questions/9142527/can-you-require-two-form-fields-to-match-with-html5 --}}
                            <div class="col-md-6">
                                <input id="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" required pattern="^\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 8 characters' : ''); if(this.checkValidity()) form.passwordConfirm.pattern = this.value;">

                                @error('newPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="passwordConfirm" class="col-md-4 col-form-label text-md-right">Повторить новый пароль</label>

                            <div class="col-md-6">
                                <input id="passwordConfirm" type="password" class="form-control" name="passwordConfirmation" required autocomplete="newPassword" pattern="^\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-change-password">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
	(function($){
        $(document).ready(function(){

			
        });
    })(jQuery);  
</script>

@endsection