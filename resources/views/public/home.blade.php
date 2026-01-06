@extends('layouts.public')

@section('title', 'Accueil - NewsPortal')

@section('content')
    <div class="hero-card mb-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <div class="category-pill mb-3">Actualites du jour</div>
                <h1 class="display-title">NewsPortal, vos articles stratetiques en un coup d oeil.</h1>
                <p class="text-muted">Une selection d analyses, reportages et dossiers pour piloter votre veille.</p>
                <form class="d-flex gap-2" method="get" action="{{ route('search') }}">
                    <input type="text" name="q" class="form-control" placeholder="Rechercher une actualite...">
                    <button class="btn btn-dark">Chercher</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="article-card">
                    <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=1200&auto=format&fit=crop" alt="hero">
                    <div class="p-3">
                        <div class="text-muted small">Focus</div>
                        <div class="fw-semibold">{{ $featuredArticle?->title ?? 'Decryptez les tendances fortes de la semaine.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Categories</h3>
            <span class="text-muted small">Navigation rapide</span>
        </div>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="category-pill text-decoration-none">{{ $category->name }}</a>
            @endforeach
        </div>
    </section>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Dernieres actualites</h3>
            <a href="{{ route('search') }}" class="text-decoration-none">Voir tout</a>
        </div>
        <div class="row g-4">
            @foreach ($latestArticles as $article)
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
            @endforeach
        </div>
    </section>

    <section class="hero-card">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h3>Newsletter executive</h3>
                <p class="text-muted">Recevez chaque semaine les points cles et les datas essentielles.</p>
            </div>
            <div class="col-lg-5">
                <form method="post" action="{{ route('newsletter.subscribe') }}" class="d-flex gap-2">
                    @csrf
                    <input type="email" name="email" class="form-control" placeholder="Votre email" required>
                    <button class="btn btn-dark">S inscrire</button>
                </form>
            </div>
        </div>
    </section>
@endsection
