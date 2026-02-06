@php
    $direction = $direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $direction }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('messages.app_name'))</title>
    @stack('meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Source+Sans+3:wght@300;400;500;600&family=Tajawal:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/brand.css') }}">
    @stack('styles')
</head>
<body class="{{ $direction }}">
    @include('partials.public_header')
    <div class="logo-strip" aria-hidden="true"></div>
    <div class="container">
        @include('partials.ad_slot', ['slot' => 'header_leaderboard'])
    </div>
    @include('partials.consent_banner')

    <main class="site-main pb-5">
        <div class="container">
            <x-flash />
            @yield('content')
        </div>
    </main>

    <footer class="footer pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    @include('partials.logo_path', ['logoClass' => 'footer-logo', 'logoAlt' => __('messages.footer_logo_alt')])
                    <h4 class="mb-3">{{ __('messages.app_name') }}</h4>
                    <p class="text-secondary">{{ __('messages.footer_description') }}</p>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <h6 class="text-uppercase">{{ __('messages.sections') }}</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a class="text-secondary text-decoration-none" href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ route('videos.index') }}">{{ __('messages.videos') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ route('search') }}">{{ __('messages.search') }}</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <h6 class="text-uppercase">{{ __('messages.footer_pages') }}</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a class="text-secondary text-decoration-none" href="{{ route('home') }}">{{ __('messages.footer_home') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ route('home') }}">{{ __('messages.footer_actualites') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ url('/categories/politique') }}">{{ __('messages.footer_politique') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ url('/categories/economie') }}">{{ __('messages.footer_economie') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ url('/categories/societe') }}">{{ __('messages.footer_societe') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ url('/categories/sport') }}">{{ __('messages.footer_sport') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ url('/contact') }}">{{ __('messages.footer_contact') }}</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ url('/a-propos') }}">{{ __('messages.footer_about') }}</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <h6 class="text-uppercase">{{ __('messages.footer_social') }}</h6>
                    <div class="footer-social">
                        <a class="footer-social__link" href="https://www.facebook.com/share/1Feu6yfCcb/?mibextid=wwXIfr" target="_blank" rel="noreferrer" aria-label="Facebook">
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a class="footer-social__link" href="https://www.threads.com/@wminfo.ma?invite=0" target="_blank" rel="noreferrer" aria-label="Threads">
                            <i class="fab fa-threads" aria-hidden="true"></i>
                        </a>
                        <a class="footer-social__link" href="https://www.instagram.com/wminfo.ma?igsh=YWh4emhmYjdzcmlu&utm_source=qr" target="_blank" rel="noreferrer" aria-label="Instagram">
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a class="footer-social__link" href="https://youtube.com/@wminfo_ma?si=UOyI9Ru5kQB3u1V_" target="_blank" rel="noreferrer" aria-label="YouTube">
                            <i class="fab fa-youtube" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h6 class="text-uppercase">{{ __('messages.contact') }}</h6>
                    <p class="text-secondary mb-1">contact@wminfo.ma</p>
                    <p class="text-secondary">{{ __('messages.footer_location') }}</p>
                </div>
            </div>
            <div class="text-secondary small mt-4">© {{ date('Y') }} {{ __('messages.app_name') }}. {{ __('messages.footer_rights') }}</div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/brand.js') }}" defer></script>
    @include('partials.ad_slot', ['slot' => 'mobile_sticky_bottom', 'class' => 'ad-mobile-sticky'])
    @stack('scripts')
</body>
</html>
