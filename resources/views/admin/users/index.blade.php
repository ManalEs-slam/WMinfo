@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')
@section('page_title', 'Gestion des utilisateurs')

@section('content')
    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
        <form class="row g-2 align-items-end" method="get">
            <div class="col-md-4">
                <label class="form-label">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nom ou email">
            </div>
            <div class="col-md-4">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="">Tous</option>
                    <option value="admin" @selected(request('role') === 'admin')>Administrateur</option>
                    <option value="editor" @selected(request('role') === 'editor')>Redacteur</option>
                    <option value="reader" @selected(request('role') === 'reader')>Lecteur</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-dark">Filtrer</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Reset</a>
            </div>
        </form>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Ajouter utilisateur</a>
    </div>

    <div class="stat-card p-0 overflow-hidden">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->display_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Editer</a>
                            <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucun utilisateur.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $users->links() }}
    </div>
@endsection
