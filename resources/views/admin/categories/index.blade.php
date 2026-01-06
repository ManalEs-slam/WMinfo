@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Gestion des categories')

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="stat-card p-4">
                <h6>Nouvelle categorie</h6>
                <form method="post" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <label class="form-label mt-2">Nom</label>
                    <input type="text" name="name" class="form-control" required>
                    <label class="form-label mt-3">Categorie parente</label>
                    <select name="parent_id" class="form-select">
                        <option value="">Aucune</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <button class="btn btn-dark mt-3">Creer</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="stat-card p-0 overflow-hidden">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Parent</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent?->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                        {{ $category->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $category->id }}">Editer</button>
                                    <form method="post" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="collapse" id="edit-{{ $category->id }}">
                                <td colspan="4">
                                    <form method="post" action="{{ route('admin.categories.update', $category) }}" class="row g-2 align-items-end">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-4">
                                            <label class="form-label">Nom</label>
                                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Parent</label>
                                            <select name="parent_id" class="form-select">
                                                <option value="">Aucun</option>
                                                @foreach ($parents as $parent)
                                                    <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)>{{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Active</label>
                                            <select name="is_active" class="form-select">
                                                <option value="1" @selected($category->is_active)>Oui</option>
                                                <option value="0" @selected(!$category->is_active)>Non</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-dark w-100">Sauver</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Aucune categorie.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
