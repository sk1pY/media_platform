<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function subscribe(User $user)
    {
      return  $user->hasPermissionTo('subscribe_users');
    }


    public function delete(User $user, User $targetUser)
    {
      return  $user->id === $targetUser->id;
    }


}
