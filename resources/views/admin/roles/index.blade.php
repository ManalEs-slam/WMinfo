@extends('layouts.admin')

@section('title', 'Gestion des roles')
@section('page_title', 'Gestion des roles')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card p-4 h-100">
                <h5>Administrateur</h5>
                <p class="text-muted">Acces total: utilisateurs, roles, categories, articles, commentaires, stats.</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-dark">{{ $counts['admin'] }} comptes</span>
                    <a href="{{ route('admin.users.create', ['role' => 'admin']) }}" class="btn btn-outline-dark btn-sm">Creer</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4 h-100">
                <h5>Redacteur</h5>
                <p class="text-muted">Cree et publie ses articles. Acces limite a son contenu.</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-dark">{{ $counts['editor'] }} comptes</span>
                    <a href="{{ route('admin.users.create', ['role' => 'editor']) }}" class="btn btn-outline-dark btn-sm">Creer</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4 h-100">
                <h5>Lecteur</h5>
                <p class="text-muted">Acces a la lecture, commentaires et partage.</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-dark">{{ $counts['reader'] }} comptes</span>
                    <a href="{{ route('admin.users.create', ['role' => 'reader']) }}" class="btn btn-outline-dark btn-sm">Creer</a>
                </div>
            </div>
        </div>
    </div>
@endsection
