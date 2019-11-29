@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтвердите свой Email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Новая ссылка верификации была отправлена на ваш email.') }}
                        </div>
                    @endif

                    {{ __('Прежде чем двигаться дальше, проверьте ссылку верификации в своём email ящике.') }}
                    {{ __('Если вы не получили письмо') }}, <a href="{{ route('verification.resend') }}" class="btn-link-forgot">{{ __('нажмите здесь для повторного запроса.') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
