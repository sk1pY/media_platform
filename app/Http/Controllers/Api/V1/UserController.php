<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user){
        $posts = $user->posts()->latest()->get();
        return response()->json($posts);
    }
}
