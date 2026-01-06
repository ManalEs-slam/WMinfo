@extends('layouts.public')

@section('title', $category->name . ' - NewsPortal')

@section('content')
    <div class="mb-4">
        <div class="category-pill">{{ $category->name }}</div>
        <h2 class="mt-2">Articles recents</h2>
        <p class="text-muted">Selection d actualites pour la categorie {{ $category->name }}.</p>
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
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-outline-dark btn-sm">Lire</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-muted">Aucun article pour le moment.</div>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $articles->links() }}
    </div>
@endsection
