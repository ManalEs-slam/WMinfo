<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NewsPortal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand: #0f172a;
            --brand-accent: #f97316;
            --brand-sand: #f8f4f0;
            --brand-slate: #64748b;
        }
        body {
            font-family: "Source Sans 3", sans-serif;
            background: radial-gradient(circle at top, #fff4e6 0%, #f8f4f0 35%, #f1f5f9 100%);
            color: var(--brand);
        }
        h1, h2, h3, h4, .display-title {
            font-family: "Playfair Display", serif;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .hero-card {
            background: #fff;
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
        }
        .category-pill {
            border-radius: 999px;
            padding: 6px 14px;
            background: rgba(249, 115, 22, 0.12);
            color: #c2410c;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .article-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            overflow: hidden;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
        }
        .article-card img {
            object-fit: cover;
            width: 100%;
            height: 200px;
        }
        .footer {
            background: #0f172a;
            color: #f8fafc;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">NewsPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navBar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('videos.index') }}">Videos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('search') }}">Recherche</a></li>
                    @auth
                        <li class="nav-item">
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-dark btn-sm" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">Connexion</a></li>
                        <li class="nav-item"><a class="btn btn-dark btn-sm" href="{{ route('register') }}">Inscription</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="pb-5">
        <div class="container">
            <x-flash />
            @yield('content')
        </div>
    </main>

    <footer class="footer pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h4 class="mb-3">NewsPortal</h4>
                    <p class="text-secondary">Plateforme d actualites professionnelles, analyses et formats video.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="text-uppercase">Sections</h6>
                    <ul class="list-unstyled">
                        <li><a class="text-secondary text-decoration-none" href="{{ route('home') }}">Accueil</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ route('videos.index') }}">Videos</a></li>
                        <li><a class="text-secondary text-decoration-none" href="{{ route('search') }}">Recherche</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-uppercase">Contact</h6>
                    <p class="text-secondary mb-1">contact@newsportal.test</p>
                    <p class="text-secondary">Paris, France</p>
                </div>
            </div>
            <div class="text-secondary small mt-4">© {{ date('Y') }} NewsPortal. Tous droits reserves.</div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
