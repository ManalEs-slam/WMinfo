<header class="admin-header d-flex align-items-center justify-content-between">
    <div>
        <h1 class="h4 mb-0">@yield('page_title', __('messages.dashboard'))</h1>
        <div class="text-muted small">Pilotage rapide de NewsPortal</div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ strtoupper(app()->getLocale()) }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">AR</a></li>
                <li><a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">FR</a></li>
                <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">EN</a></li>
            </ul>
        </div>
        <div class="text-end">
            <div class="fw-semibold">{{ auth()->user()?->display_name ?? 'Admin' }}</div>
            <div class="text-muted small">{{ auth()->user()?->role ?? 'admin' }}</div>
        </div>
        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center"
             style="width:42px;height:42px;">
            @if (auth()->user()?->avatar_path)
                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="avatar" class="rounded-circle" style="width:42px;height:42px;object-fit:cover;">
            @else
                <span class="fw-semibold">{{ strtoupper(substr(auth()->user()?->first_name ?? 'A', 0, 1)) }}</span>
            @endif
        </div>
    </div>
</header>
