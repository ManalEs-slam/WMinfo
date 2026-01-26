@php
    $locales = ['ar', 'fr', 'en'];
    $currentLocale = app()->getLocale();
@endphp

<div class="offcanvas-overlay" data-offcanvas-overlay></div>

<header class="public-header site-header">
    <div class="public-header-top">
        <a class="brand-link brand" href="{{ route('home') }}">
            @include('partials.logo_path', ['logoClass' => 'brand-logo', 'logoAlt' => 'WNانفو'])
        </a>
        <div class="header-actions">
            <div class="header-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-dark btn-sm">S'inscrire</a>
                    @endif
                @endguest
                @auth
                    <span class="header-auth__user">{{ auth()->user()->display_name ?? auth()->user()->email }}</span>
                    <form method="post" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-dark btn-sm" type="submit">Se déconnecter</button>
                    </form>
                @endauth
            </div>
            <div class="header-social" aria-label="{{ __('messages.follow_us') }}">
                <a href="https://www.facebook.com" target="_blank" rel="noreferrer" aria-label="{{ __('messages.social_facebook') }}">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                </a>
                <a href="https://x.com" target="_blank" rel="noreferrer" aria-label="{{ __('messages.social_x') }}">
                    <i class="fab fa-x" aria-hidden="true"></i>
                </a>
                <a href="https://www.instagram.com" target="_blank" rel="noreferrer" aria-label="{{ __('messages.social_instagram') }}">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="https://www.youtube.com" target="_blank" rel="noreferrer" aria-label="{{ __('messages.social_youtube') }}">
                    <i class="fab fa-youtube" aria-hidden="true"></i>
                </a>
                <a href="https://www.tiktok.com" target="_blank" rel="noreferrer" aria-label="{{ __('messages.social_tiktok') }}">
                    <i class="fab fa-tiktok" aria-hidden="true"></i>
                </a>
                <a href="https://www.linkedin.com" target="_blank" rel="noreferrer" aria-label="{{ __('messages.social_linkedin') }}">
                    <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                </a>
            </div>
            <div class="header-lang" aria-label="{{ __('messages.language_switcher') }}">
                @foreach ($locales as $locale)
                    <a href="{{ route('lang.switch', $locale) }}" class="{{ $currentLocale === $locale ? 'active' : '' }}">
                        {{ strtoupper($locale) }}
                    </a>
                @endforeach
            </div>
            <button class="theme-toggle" type="button" data-theme-toggle aria-label="Basculer le mode sombre" aria-pressed="false">
                <i class="fa fa-moon icon-moon" aria-hidden="true"></i>
                <i class="fa fa-sun icon-sun" aria-hidden="true"></i>
            </button>
            <button class="header-hamburger" type="button" data-offcanvas-toggle aria-label="{{ __('messages.open_menu') }}">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <nav class="public-header-categories" aria-label="{{ __('messages.categories') }}">
        <ul>
            @forelse ($navCategories ?? [] as $category)
                <li><a href="{{ route('categories.show', $category) }}">{{ $category->name_translated }}</a></li>
            @empty
                <li><span class="text-muted">{{ __('messages.no_categories') }}</span></li>
            @endforelse
        </ul>
    </nav>
</header>

<aside class="offcanvas-menu" aria-hidden="true" data-offcanvas-panel>
    <button class="offcanvas-close" type="button" data-offcanvas-close aria-label="{{ __('messages.close_menu') }}">
        <i class="fa fa-times" aria-hidden="true"></i>
    </button>

    <div class="offcanvas-section">
        <h4>{{ __('messages.quick_links') }}</h4>
        <ul>
            <li><a href="{{ route('home') }}">{{ __('messages.all_news') }}</a></li>
            <li><a href="{{ route('home') }}">{{ __('messages.headline_news') }}</a></li>
            <li><a href="{{ route('search') }}">{{ __('messages.most_commented') }}</a></li>
            <li><a href="{{ route('search') }}">{{ __('messages.most_viewed') }}</a></li>
            <li><a href="{{ route('videos.index') }}">{{ __('messages.programs') }}</a></li>
            <li><a href="{{ route('home') }}">{{ __('messages.visitors_right_now') }}</a></li>
        </ul>
    </div>

    <div class="offcanvas-section">
        <h4>{{ __('messages.sections') }}</h4>
        <ul>
            @forelse ($navCategories ?? [] as $category)
                <li><a href="{{ route('categories.show', $category) }}">{{ $category->name_translated }}</a></li>
            @empty
                <li><span class="text-muted">{{ __('messages.no_categories') }}</span></li>
            @endforelse
        </ul>
    </div>

    <div class="offcanvas-section">
        <h4>{{ __('messages.language_versions') }}</h4>
        <ul>
            <li><a href="{{ route('lang.switch', 'ar') }}">{{ __('messages.arabic_version') }}</a></li>
            <li><a href="{{ route('lang.switch', 'fr') }}">{{ __('messages.french_version') }}</a></li>
            <li><a href="{{ route('lang.switch', 'en') }}">{{ __('messages.english_version') }}</a></li>
        </ul>
    </div>
</aside>
