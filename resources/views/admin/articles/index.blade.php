@extends('layouts.admin')

@section('title', 'Gestion des articles')
@section('page_title', 'Gestion des articles')

@section('content')
    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
        <form class="row g-2 align-items-end" method="get">
            <div class="col-md-3">
                <label class="form-label">Region</label>
                <input type="text" name="region" value="{{ request('region') }}" class="form-control" placeholder="Europe">
            </div>
            <div class="col-md-3">
                <label class="form-label">Categorie</label>
                <select name="category" class="form-select">
                    <option value="">Toutes</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Auteur</label>
                <select name="author" class="form-select">
                    <option value="">Tous</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" @selected(request('author') == $author->id)>
                            {{ $author->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Titre">
            </div>
            <div class="col-12">
                <button class="btn btn-dark">Filtrer</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.articles.index') }}">Reset</a>
            </div>
        </form>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Ajouter un nouvel article</a>
    </div>

    <div class="stat-card p-0 overflow-hidden">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Categorie</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $article->title }}</div>
                            <div class="text-muted small">{{ $article->region ?? 'Global' }}</div>
                        </td>
                        <td>{{ $article->author?->display_name }}</td>
                        <td>{{ $article->category?->name ?? 'Sans categorie' }}</td>
                        <td>
                            <span class="badge bg-{{ $article->status === 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                        <td>{{ $article->published_at?->format('d/m/Y') ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-outline-primary">Editer</a>
                            <form method="post" action="{{ route('admin.articles.destroy', $article) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Supprimer?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucun article.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $articles->links() }}
    </div>
@endsection
