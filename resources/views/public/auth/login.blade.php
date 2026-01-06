@extends('layouts.public')

@section('title', 'Connexion - NewsPortal')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="hero-card">
                <h3 class="mb-3">Connexion</h3>
                <form method="post" action="{{ route('login.perform') }}">
                    @csrf
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control mb-3" required>
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control mb-4" required>
                    <button class="btn btn-dark w-100">Se connecter</button>
                </form>
                <div class="text-muted small mt-3">
                    Pas de compte? <a href="{{ route('register') }}">Inscription</a>
                </div>
            </div>
        </div>
    </div>
@endsection
