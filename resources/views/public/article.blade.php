@extends('layouts.public')

@section('title', $article->title . ' - ' . __('messages.app_name'))

@push('meta')
    @php
        $rawImage = $article->image_path ?? $article->featured_image ?? null;
        $rawImage = $rawImage ? ltrim($rawImage, '/') : null;
        $fallbackImage = asset('assets/images/placeholder.svg');
        $imageUrl = $fallbackImage;
        if ($rawImage) {
            if (\Illuminate\Support\Str::startsWith($rawImage, 'uploads/')) {
                $imageUrl = asset($rawImage);
            } elseif (\Illuminate\Support\Str::startsWith($rawImage, 'storage/')) {
                $imageUrl = asset($rawImage);
            } elseif (file_exists(public_path('uploads/articles/' . $rawImage))) {
                $imageUrl = asset('uploads/articles/' . $rawImage);
            } else {
                $imageUrl = asset('storage/' . $rawImage);
            }
        }
        $descriptionSource = $article->excerpt ?: strip_tags($article->content ?? '');
        $description = \Illuminate\Support\Str::limit(trim($descriptionSource), 160, '...');
        $currentUrl = url()->current();
    @endphp
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:image" content="{{ $imageUrl }}">
    <meta property="og:image:secure_url" content="{{ $imageUrl }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $imageUrl }}">
@endpush

@section('content')
    <div class="article-page">
        <div class="article-container">
            <div class="article-grid">
                <main class="article-content">
                    <div class="category-pill mb-3">{{ $article->category?->name_translated ?? 'General' }}</div>
                    <h1 class="mb-2">{{ $article->title }}</h1>
                    <p class="article-meta mb-4">
                        {{ __('messages.by') ?? 'Par' }} {{ $article->author?->display_name ?? 'Equipe NewsPortal' }} •
                        {{ $article->published_at?->format('d/m/Y') ?? 'Draft' }}
                    </p>

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
                    <figure class="article-featured-image">
                        <img src="{{ $src }}" alt="{{ $article->title }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';">
                    </figure>

                    <div class="article-body mb-4">{!! $article->content !!}</div>

                    <div class="article-actions mb-5">
                        <button class="btn btn-outline-dark btn-sm">Partager LinkedIn</button>
                        <button class="btn btn-outline-dark btn-sm">Partager X</button>
                        <button class="btn btn-outline-dark btn-sm">Partager Facebook</button>
                        @if ($preview)
                            <form method="post" action="{{ route('admin.articles.publish', $article) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-dark btn-sm">Publier</button>
                            </form>
                        @endif
                    </div>

                    <div class="hero-card mb-4 comments-card">
                        <h4 class="comments-card__title">Commentaires</h4>
                        <form method="post" action="{{ route('articles.comment', $article) }}" class="comments-card__form">
                            @csrf
                            <label class="comments-card__label" for="commentContent">Votre commentaire</label>
                            <textarea id="commentContent" name="content" class="form-control comments-card__textarea" rows="3" maxlength="500" placeholder="Votre commentaire"></textarea>
                            <div class="comments-card__actions">
                                <small class="text-muted" id="charCount">0 / 500</small>
                                <button class="btn btn-dark btn-sm" @guest disabled @endguest>Envoyer</button>
                            </div>
                        </form>
                    </div>

                    <div class="comments-list comments-list--spaced">
                        @forelse ($article->comments as $comment)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="fw-semibold">{{ $comment->user?->display_name ?? 'Invite' }}</div>
                                <div class="text-muted small mb-2">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                                <div>{{ $comment->content }}</div>
                            </div>
                        @empty
                            <div class="text-muted comments-empty">{{ __('messages.no_comments_yet') }}</div>
                        @endforelse
                    </div>
                </main>

                <aside class="article-sidebar">
                    @include('partials.ad_slot', ['slot' => 'article_sidebar', 'class' => 'ad-sidebar'])
                </aside>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const textarea = document.querySelector('textarea[name="content"]');
        const counter = document.getElementById('charCount');
        if (textarea && counter) {
            textarea.addEventListener('input', () => {
                counter.textContent = `${textarea.value.length} / 500`;
            });
        }
    </script>
@endpush
