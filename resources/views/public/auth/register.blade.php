@extends('layouts.public')

@section('title', 'Inscription - NewsPortal')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="hero-card">
                <h3 class="mb-3">Inscription</h3>
                <form method="post" action="{{ route('register.perform') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Prenom</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <button class="btn btn-dark w-100 mt-4">Creer un compte</button>
                </form>
                <div class="text-muted small mt-3">
                    Deja inscrit? <a href="{{ route('login') }}">Connexion</a>
                </div>
            </div>
        </div>
    </div>
@endsection
