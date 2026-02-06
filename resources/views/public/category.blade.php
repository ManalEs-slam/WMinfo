@extends('layouts.public')

@section('title', $category->name_translated . ' - ' . __('messages.app_name'))

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4">
                <div class="category-pill">{{ $category->name_translated }}</div>
                <h2 class="mt-2">{{ __('public.recent_articles') }}</h2>
                <p class="text-muted">{{ __('public.category_selection', ['name' => $category->name_translated]) }}</p>
            </div>

            <div class="row g-4">
                @forelse ($articles as $article)
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
                @empty
                    <div class="text-muted">{{ __('messages.no_articles_yet') ?? 'Aucun article pour le moment.' }}</div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="col-lg-4 d-none d-lg-flex flex-column">
            @include('partials.ad_slot', ['slot' => 'category_sidebar', 'class' => 'ad-sidebar'])
        </div>
    </div>
@endsection
