@extends('layouts.public')

@section('title', __('messages.login') . ' - ' . __('messages.app_name'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 auth-shell">
            <div class="hero-card auth-card">
                <h3 class="auth-card__title">{{ __('messages.login') }}</h3>
                <form method="post" action="{{ route('login.perform') }}" class="auth-card__form">
                    @csrf
                    <label class="form-label">{{ __('messages.email_address') }}</label>
                    <input type="email" name="email" class="form-control" required>
                    <label class="form-label">{{ __('validation.attributes.password') }}</label>
                    <input type="password" name="password" class="form-control" required>
                    <button class="btn btn-dark w-100">{{ __('messages.login') }}</button>
                </form>
                <div class="text-muted small auth-card__hint">
                    {{ __('messages.no_account') }} <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
