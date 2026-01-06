@extends('layouts.admin')

@section('title', $user->exists ? 'Edition utilisateur' : 'Ajout utilisateur')
@section('page_title', $user->exists ? 'Edition utilisateur' : 'Ajout utilisateur')

@section('content')
    <form method="post" enctype="multipart/form-data" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if ($user->exists)
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="stat-card p-4 mb-4">
                    <h6>Informations</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Prenom</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telephone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>
                </div>

                <div class="stat-card p-4">
                    <h6>Permissions specifiques</h6>
                    <textarea name="permissions" class="form-control" rows="3" placeholder="ex: publish,moderate">{{ old('permissions', is_array($user->permissions) ? implode(', ', $user->permissions) : '') }}</textarea>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stat-card p-4 mb-4">
                    <h6>Role et statut</h6>
                    <label class="form-label mt-2">Role</label>
                    <select name="role" class="form-select">
                        <option value="admin" @selected(old('role', $user->role ?? $rolePreset) === 'admin')>Administrateur</option>
                        <option value="editor" @selected(old('role', $user->role ?? $rolePreset) === 'editor')>Redacteur</option>
                        <option value="reader" @selected(old('role', $user->role ?? $rolePreset) === 'reader')>Lecteur</option>
                    </select>

                    <label class="form-label mt-3">Statut</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', $user->status) === 'active')>Actif</option>
                        <option value="inactive" @selected(old('status', $user->status) === 'inactive')>Inactif</option>
                    </select>
                </div>

                <div class="stat-card p-4 mb-4">
                    <h6>Photo de profil</h6>
                    <input type="file" name="avatar" class="form-control">
                    @if ($user->avatar_path)
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar" class="img-fluid rounded-3 mt-3">
                    @endif
                </div>

                <div class="stat-card p-4">
                    <h6>Mot de passe</h6>
                    <input type="password" name="password" class="form-control mb-2" placeholder="********">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer">
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-dark">Sauvegarder</button>
                </div>
            </div>
        </div>
    </form>
@endsection
