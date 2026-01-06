<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NewsPortal Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-bg: #0f141a;
            --admin-panel: #151b23;
            --admin-accent: #ff7a1a;
            --admin-text: #eef2f6;
            --admin-muted: #9aa4b2;
        }
        body {
            font-family: "Work Sans", sans-serif;
            background: #f3f5f8;
        }
        .admin-shell {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 260px;
            background: var(--admin-bg);
            color: var(--admin-text);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 28px 20px;
        }
        .admin-brand {
            font-family: "Space Grotesk", sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
            color: var(--admin-text);
        }
        .admin-menu a {
            color: var(--admin-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 8px;
        }
        .admin-menu a.active,
        .admin-menu a:hover {
            background: var(--admin-panel);
            color: var(--admin-text);
        }
        .admin-content {
            margin-left: 260px;
            width: calc(100% - 260px);
        }
        .admin-header {
            background: #fff;
            padding: 20px 32px;
            border-bottom: 1px solid #e7ebf1;
        }
        .admin-header h1 {
            font-family: "Space Grotesk", sans-serif;
            font-weight: 600;
        }
        .stat-card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 16px 30px rgba(15, 20, 26, 0.08);
        }
        .badge-soft {
            background: rgba(255, 122, 26, 0.12);
            color: #c45500;
            border-radius: 999px;
            padding: 6px 12px;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-shell">
        @include('admin.partials.sidebar')
        <div class="admin-content">
            @include('admin.partials.header')
            <main class="p-4 p-lg-5">
                <x-flash />
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
