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
        return $user -> hasPermissionTo('create_posts');
    }

    public function update(User $user,Post $post){
        return $user->id === $post->user_id;
    }

    public function destroy(User $user,Post $post){
        if( $user -> hasPermissionTo('delete_posts')){
            return $user->id === $post->user_id;
        }
    }
}
