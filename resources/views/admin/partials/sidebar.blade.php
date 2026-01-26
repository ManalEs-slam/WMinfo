<aside class="admin-sidebar">
    <div class="admin-brand mb-4">
        <a class="brand-link text-decoration-none" href="{{ route('admin.dashboard') ?? '/admin' }}">
            @include('partials.logo_path', ['logoClass' => 'brand-logo brand-logo--sidebar', 'logoAlt' => 'WNانفو'])
        </a>
    </div>
    <div class="admin-menu">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            {{ __('messages.dashboard') }}
        </a>
        <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
            {{ __('messages.articles') }}
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            {{ __('messages.categories') }}
        </a>
        <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
            {{ __('messages.comments') }}
        </a>
        <a href="{{ route('admin.videos.index') }}" class="{{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
            {{ __('messages.videos') }}
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            {{ __('messages.users') }}
        </a>
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            {{ __('messages.roles') }}
        </a>
        <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            {{ __('messages.profile') }}
        </a>
    </div>
</aside>
