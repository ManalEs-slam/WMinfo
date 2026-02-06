@extends('layouts.public')

@section('title', __('messages.home') . ' - ' . __('messages.app_name'))

@section('content')
    @if ($sliderArticles->isNotEmpty())
        <section class="hero-card news-slider mb-5" data-news-slider>
            <a class="news-slider__headline" data-slider-headline href="#"></a>
            <div class="news-slider__viewport">
                <div class="news-slider__track">
                    @foreach ($sliderArticles as $index => $article)
                        @php
                            $img = $article->image_path ?? $article->featured_image ?? null;
                            $img = $img ? ltrim($img, '/') : null;
                            $placeholder = asset('assets/images/placeholder.svg');
                            $src = $placeholder;
                            if ($img) {
                                if (\Illuminate\Support\Str::startsWith($img, 'uploads/')) {
                                    $src = asset($img);
                                } elseif (\Illuminate\Support\Str::startsWith($img, 'storage/')) {
                                    $src = asset($img);
                                } elseif (file_exists(public_path('uploads/articles/' . $img))) {
                                    $src = asset('uploads/articles/' . $img);
                                } else {
                                    $src = asset('storage/' . $img);
                                }
                            }
                        @endphp
                        <a class="news-slide"
                           href="{{ route('articles.show', $article) }}"
                           data-slide
                           data-title="{{ $article->title }}"
                           data-url="{{ route('articles.show', $article) }}">
                            <img src="{{ $src }}" alt="{{ $article->title }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';">
                        </a>
                    @endforeach
                </div>
            </div>
            <button class="news-slider__nav news-slider__nav--prev" type="button" data-slider-prev aria-label="Précédent">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button class="news-slider__nav news-slider__nav--next" type="button" data-slider-next aria-label="Suivant">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button>
            <div class="news-slider__dots" role="tablist">
                @foreach ($sliderArticles as $index => $article)
                    <button type="button" class="news-slider__dot" data-slider-dot="{{ $index }}" aria-label="Aller à l'article {{ $index + 1 }}"></button>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>{{ __('messages.latest_articles') }}</h3>
            <a href="{{ route('search') }}" class="text-decoration-none">{{ __('messages.see_all') }}</a>
        </div>
        <div class="row g-4">
            @foreach ($latestArticles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="article-card h-100">
                        @php
                            $img = $article->image_path ?? $article->featured_image ?? null;
                            $img = $img ? ltrim($img, '/') : null;
                            $placeholder = asset('assets/images/placeholder.svg');
                            $src = $placeholder;
                            if ($img) {
                                if (\Illuminate\Support\Str::startsWith($img, 'uploads/')) {
                                    $src = asset($img);
                                } elseif (\Illuminate\Support\Str::startsWith($img, 'storage/')) {
                                    $src = asset($img);
                                } elseif (file_exists(public_path('uploads/articles/' . $img))) {
                                    $src = asset('uploads/articles/' . $img);
                                } else {
                                    $src = asset('storage/' . $img);
                                }
                            }
                        @endphp
                        <img src="{{ $src }}" alt="article" onerror="this.onerror=null;this.src='{{ $placeholder }}';">
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
                    @php
                        $videoSrc = $video->video_url ?: ($video->video_file ? asset('storage/' . $video->video_file) : '');
                    @endphp
                    <button type="button" class="video-card"
                            data-video-type="{{ $video->video_url ? 'embed' : 'file' }}"
                            data-video-src="{{ $videoSrc }}">
                        <div class="video-card__media">
                            @php
                                $thumb = $video->thumbnail ? asset('storage/' . $video->thumbnail) : 'https://images.unsplash.com/photo-1512428559087-560fa5ceab42?q=80&w=1200&auto=format&fit=crop';
                                $thumbFallback = asset('assets/images/placeholder.svg');
                            @endphp
                            <img src="{{ $thumb }}" alt="{{ $video->title }}" onerror="this.onerror=null;this.src='{{ $thumbFallback }}';">
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
                <video controls preload="metadata">
                    <source src="" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const sliderRoot = document.querySelector('[data-news-slider]');
        if (sliderRoot) {
            const track = sliderRoot.querySelector('.news-slider__track');
            const slides = Array.from(sliderRoot.querySelectorAll('[data-slide]'));
            const prevBtn = sliderRoot.querySelector('[data-slider-prev]');
            const nextBtn = sliderRoot.querySelector('[data-slider-next]');
            const dots = Array.from(sliderRoot.querySelectorAll('[data-slider-dot]'));
            const headline = sliderRoot.querySelector('[data-slider-headline]');
            let index = 0;
            let timer = null;
            let startX = 0;
            let isDragging = false;

            const update = (nextIndex) => {
                index = (nextIndex + slides.length) % slides.length;
                track.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach((dot, idx) => {
                    dot.classList.toggle('is-active', idx === index);
                });
                if (headline) {
                    const active = slides[index];
                    headline.textContent = active.dataset.title || '';
                    headline.href = active.dataset.url || '#';
                }
            };

            const startAuto = () => {
                if (slides.length < 2) return;
                timer = setInterval(() => update(index + 1), 6000);
            };

            const stopAuto = () => {
                if (timer) clearInterval(timer);
            };

            prevBtn?.addEventListener('click', () => update(index - 1));
            nextBtn?.addEventListener('click', () => update(index + 1));
            dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => update(idx));
            });

            sliderRoot.addEventListener('mouseenter', stopAuto);
            sliderRoot.addEventListener('mouseleave', startAuto);

            sliderRoot.addEventListener('touchstart', (event) => {
                startX = event.touches[0].clientX;
                isDragging = true;
                stopAuto();
            }, { passive: true });

            sliderRoot.addEventListener('touchmove', (event) => {
                if (!isDragging) return;
                const delta = event.touches[0].clientX - startX;
                if (Math.abs(delta) > 40) {
                    isDragging = false;
                    update(delta > 0 ? index - 1 : index + 1);
                }
            }, { passive: true });

            sliderRoot.addEventListener('touchend', () => {
                isDragging = false;
                startAuto();
            });

            update(0);
            startAuto();
        }

        const videoModal = document.querySelector('[data-video-modal]');
        const modalFrame = videoModal?.querySelector('iframe');
        const modalVideo = videoModal?.querySelector('video');
        const modalVideoSource = modalVideo?.querySelector('source');

        const toYoutubeEmbed = (url) => {
            if (!url) return '';
            const trimmed = url.trim();
            if (trimmed.includes('youtube.com/embed/')) return trimmed;
            let match = trimmed.match(/youtu\.be\/([A-Za-z0-9_-]+)/);
            if (!match) {
                match = trimmed.match(/[?&]v=([A-Za-z0-9_-]+)/);
            }
            return match ? `https://www.youtube.com/embed/${match[1]}` : '';
        };

        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('click', () => {
                if (!videoModal || !modalFrame || !modalVideo || !modalVideoSource) return;
                const type = card.dataset.videoType;
                const rawSrc = card.dataset.videoSrc || '';
                modalFrame.style.display = 'none';
                modalVideo.style.display = 'none';
                modalFrame.src = '';
                modalVideoSource.src = '';

                if (type === 'embed') {
                    const embedSrc = toYoutubeEmbed(rawSrc);
                    if (!embedSrc) return;
                    modalFrame.src = embedSrc;
                    modalFrame.style.display = 'block';
                } else if (type === 'file' && rawSrc) {
                    modalVideoSource.src = rawSrc;
                    modalVideo.load();
                    modalVideo.style.display = 'block';
                }

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
                if (modalVideo) {
                    modalVideo.pause();
                }
                if (modalVideoSource) {
                    modalVideoSource.src = '';
                }
            });
        });
    </script>
@endpush
