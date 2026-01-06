<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function view(User $user, Article $article): bool
    {
        return $user->isAdmin() || $article->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, Article $article): bool
    {
        return $user->isAdmin() || $article->user_id === $user->id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->isAdmin() || $article->user_id === $user->id;
    }

    public function publish(User $user, Article $article): bool
    {
        return $user->isAdmin() || $article->user_id === $user->id;
    }
}
