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
