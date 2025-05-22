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
        $user->hasPermissionTo('subscribe_users');
    }

    public function update(User $authUser, User $user)
    {

        return $authUser->id === $user->id;
    }


}
