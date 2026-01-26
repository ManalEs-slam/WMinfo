@extends('layouts.public')

@section('title', __('messages.register') . ' - ' . __('messages.app_name'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 auth-shell">
            <div class="hero-card auth-card">
                <h3 class="auth-card__title">{{ __('messages.register') }}</h3>
                <form method="post" action="{{ route('register.perform') }}" class="auth-card__form">
                    @csrf
                    <div class="row g-3 auth-card__grid">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('validation.attributes.first_name') }}</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('validation.attributes.last_name') }}</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('messages.email_address') }}</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('validation.attributes.password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('validation.attributes.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <button class="btn btn-dark w-100 auth-card__submit">{{ __('messages.create_account') }}</button>
                </form>
                <div class="text-muted small auth-card__hint">
                    {{ __('messages.already_registered') }} <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
