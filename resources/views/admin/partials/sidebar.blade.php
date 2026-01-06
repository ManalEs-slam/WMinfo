<aside class="admin-sidebar">
    <div class="admin-brand mb-4">NewsPortal</div>
    <div class="admin-menu">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
            Articles
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            Categories
        </a>
        <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
            Commentaires
        </a>
        <a href="{{ route('admin.videos.index') }}" class="{{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
            Videos
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            Utilisateurs
        </a>
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            Roles
        </a>
        <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            Profil
        </a>
    </div>
</aside>
