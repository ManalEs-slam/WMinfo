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
                            <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=1200&auto=format&fit=crop' }}" alt="article">
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
