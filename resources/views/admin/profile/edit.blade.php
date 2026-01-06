@extends('layouts.admin')

@section('title', 'Profil utilisateur')
@section('page_title', 'Profil utilisateur')

@section('content')
    <form method="post" enctype="multipart/form-data" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="stat-card p-4 mb-4">
                    <h6>Informations personnelles</h6>
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
                    <h6>Preferences</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Langue</label>
                            <input type="text" name="language" class="form-control" value="{{ old('language', $user->language) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fuseau horaire</label>
                            <input type="text" name="timezone" class="form-control" value="{{ old('timezone', $user->timezone) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stat-card p-4 mb-4">
                    <h6>Photo</h6>
                    <input type="file" name="avatar" class="form-control">
                    @if ($user->avatar_path)
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar" class="img-fluid rounded-3 mt-3">
                    @endif
                </div>

                <div class="stat-card p-4">
                    <h6>Changer mot de passe</h6>
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
