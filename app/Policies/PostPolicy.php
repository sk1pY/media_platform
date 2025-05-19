<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_posts');
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function destroy(User $user, Post $post)
    {
        if ($user->hasPermissionTo('delete_posts')) {
            return $user->id === $post->user_id;
        }
    }

    public function like(User $user)
    {
        return $user->hasPermissionTo('like_posts');
    }

    public function bookmark(User $user)
    {
        return $user->hasPermissionTo('bookmark_posts');
    }
    public function hidden(User $user)
    {
        return $user->hasPermissionTo('hidden_posts');
    }
    public function complain(User $user)
    {
        return $user->hasPermissionTo('complain_posts');
    }
}
