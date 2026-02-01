@extends('layouts.public')

@section('title', 'Recherche - NewsPortal')

@section('content')
    <div class="hero-card mb-4">
        <form method="get" action="{{ route('search') }}" class="row g-2 align-items-center">
            <div class="col-md-10">
                <input type="text" name="q" class="form-control" value="{{ $term }}" placeholder="Rechercher une actualite...">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100">Rechercher</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        @forelse ($articles as $article)
            <div class="col-md-6 col-lg-4">
                <div class="article-card h-100">
                    <img src="{{ $article->image_path ? asset($article->image_path) : 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=1200&auto=format&fit=crop' }}" alt="article">
                    <div class="p-3">
                        <div class="text-muted small">{{ $article->category?->name ?? 'General' }}</div>
                        <h5 class="mt-2">{{ $article->title }}</h5>
                        <p class="text-muted small">{{ $article->excerpt }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-outline-dark btn-sm">Lire</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-muted">Aucun resultat.</div>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $articles->links() }}
    </div>
@endsection
