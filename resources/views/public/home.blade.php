@extends('layouts.public')

@section('title', __('messages.home') . ' - ' . __('messages.app_name'))

@section('content')
    <div class="hero-card hero-spotlight mb-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <div class="category-pill mb-3 hero-spotlight__badge">{{ __('messages.daily_news') }}</div>
                <h1 class="display-title">{{ __('messages.hero_title') }}</h1>
                <p class="text-muted">{{ __('messages.hero_subtitle') }}</p>
                <form class="d-flex gap-2 hero-spotlight__search" method="get" action="{{ route('search') }}">
                    <input type="text" name="q" class="form-control" placeholder="{{ __('messages.search_placeholder') }}">
                    <button class="btn btn-dark">{{ __('messages.search') }}</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="article-card hero-spotlight__media">
                    <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=1200&auto=format&fit=crop" alt="hero">
                    <div class="p-3 hero-spotlight__caption">
                        <div class="text-muted small">{{ __('messages.focus') }}</div>
                        <div class="fw-semibold">{{ $featuredArticle?->title ?? __('messages.featured_article_placeholder') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>{{ __('messages.categories') }}</h3>
            <span class="text-muted small">{{ __('messages.quick_nav') }}</span>
        </div>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="category-pill text-decoration-none">{{ $category->name_translated }}</a>
            @endforeach
        </div>
    </section>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>{{ __('messages.latest_articles') }}</h3>
            <a href="{{ route('search') }}" class="text-decoration-none">{{ __('messages.see_all') }}</a>
        </div>
        <div class="row g-4">
            @foreach ($latestArticles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="article-card h-100">
                        <img src="{{ $article->featured_image ? Illuminate\Support\Facades\Storage::url($article->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=1200&auto=format&fit=crop' }}" alt="article">
                        <div class="p-3">
                            <div class="text-muted small">{{ $article->category?->name ?? 'General' }}</div>
                            <h5 class="mt-2">{{ $article->title }}</h5>
                            <p class="text-muted small">{{ $article->excerpt }}</p>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-outline-dark btn-sm">{{ __('messages.read_more') }}</a>
                        </div>
                    </div>
                </div>
                @if ($loop->iteration === 3)
                    <div class="col-12">
                        @include('partials.ad_slot', ['slot' => 'home_infeed_1', 'class' => 'ad-inline'])
                    </div>
                @endif
            @endforeach
        </div>
        <div class="mt-4">
            {{ $latestArticles->links() }}
        </div>
    </section>

    <section class="hero-card newsletter-card">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h3>{{ __('messages.newsletter_title') }}</h3>
                <p class="text-muted">{{ __('messages.newsletter_subtitle') }}</p>
            </div>
            <div class="col-lg-5">
                <form method="post" action="{{ route('newsletter.subscribe') }}" class="d-flex gap-2 newsletter-card__form">
                    @csrf
                    <input type="email" name="email" class="form-control" placeholder="{{ __('messages.your_email') }}" required>
                    <button class="btn btn-dark">{{ __('messages.subscribe') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
