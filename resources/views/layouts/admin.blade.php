@php
    $direction = $direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $direction }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('messages.app_name') . ' ' . __('messages.admin_panel'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/brand.css') }}">
    <style>
        body {
            font-family: "Work Sans", sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }
        .admin-shell {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 260px;
            background: #ffffff;
            color: #1f2937;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 28px 20px;
            box-shadow: 0 20px 40px rgba(31, 41, 55, 0.08);
            border-right: 1px solid rgba(31, 41, 55, 0.08);
        }
        html[dir="rtl"] .admin-sidebar {
            right: 0;
            left: auto;
        }
        .admin-menu a {
            color: #4b5563;
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
            background: rgba(209, 26, 42, 0.12);
            color: #1f2937;
        }
        .admin-content {
            margin-left: 260px;
            width: calc(100% - 260px);
        }
        html[dir="rtl"] .admin-content {
            margin-left: 0;
            margin-right: 260px;
        }
        .admin-header {
            background: #ffffff;
            padding: 20px 32px;
            border-bottom: 1px solid rgba(31, 41, 55, 0.08);
            color: #1f2937;
            box-shadow: 0 12px 28px rgba(31, 41, 55, 0.08);
        }
        .admin-header h1 {
            font-family: "Space Grotesk", sans-serif;
            font-weight: 600;
            color: #111827;
        }
        .stat-card {
            border: none;
            border-radius: 18px;
            background: var(--brand-white);
            border: 1px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
        }
        .badge-soft {
            background: rgba(209, 26, 42, 0.18);
            color: var(--brand-red);
            border-radius: 999px;
            padding: 6px 12px;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body class="{{ $direction }}">
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
