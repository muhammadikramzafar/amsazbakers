<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;

class BlogPostPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('super-admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'editor']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'editor']);
    }

    public function update(User $user, BlogPost $blogPost): bool
    {
        return $user->hasRole('admin') || $blogPost->user_id === $user->id;
    }

    public function delete(User $user, BlogPost $blogPost): bool
    {
        return $user->hasRole('admin') || $blogPost->user_id === $user->id;
    }
}
