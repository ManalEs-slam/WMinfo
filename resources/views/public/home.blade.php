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
                        <img src="{{ $article->image_path ? asset($article->image_path) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=1200&auto=format&fit=crop' }}" alt="article">
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

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>صوت و صورة</h3>
            <a href="{{ route('videos.index') }}" class="text-decoration-none">Vidéos</a>
        </div>
        <div class="row g-4 video-grid">
            @foreach ($videos as $video)
                <div class="col-12 col-sm-6 col-lg-3">
                    <button type="button" class="video-card" data-video-url="{{ $video->video_url }}">
                        <div class="video-card__media">
                            <img src="{{ $video->thumbnail ? asset('storage/' . $video->thumbnail) : 'https://images.unsplash.com/photo-1512428559087-560fa5ceab42?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ $video->title }}">
                            <span class="video-card__overlay"></span>
                            <span class="video-card__play">
                                <i class="fa fa-play" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="video-card__body">
                            <div class="video-card__title">
                                {{ app()->getLocale() === 'ar' ? ($video->title_ar ?: $video->title_fr ?: $video->title) : ($video->title_fr ?: $video->title) }}
                            </div>
                            <div class="text-muted small">{{ optional($video->published_at)->format('d/m/Y') }}</div>
                        </div>
                    </button>
                </div>
            @endforeach
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

    <div class="video-modal" data-video-modal aria-hidden="true">
        <div class="video-modal__backdrop" data-video-close></div>
        <div class="video-modal__panel" role="dialog" aria-modal="true">
            <button class="video-modal__close" type="button" data-video-close aria-label="Fermer">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
            <div class="video-modal__frame">
                <iframe src="" title="Video player" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const videoModal = document.querySelector('[data-video-modal]');
        const modalFrame = videoModal?.querySelector('iframe');

        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('click', () => {
                if (!videoModal || !modalFrame) return;
                modalFrame.src = card.dataset.videoUrl || '';
                videoModal.classList.add('is-open');
                videoModal.setAttribute('aria-hidden', 'false');
            });
        });

        videoModal?.querySelectorAll('[data-video-close]').forEach(btn => {
            btn.addEventListener('click', () => {
                videoModal.classList.remove('is-open');
                videoModal.setAttribute('aria-hidden', 'true');
                if (modalFrame) {
                    modalFrame.src = '';
                }
            });
        });
    </script>
@endpush
