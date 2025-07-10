<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\UserUpdateRequest;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\UserUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user,UserUpdateService $userUpdateService)
    {
        $validated = $request->validated();
        $userUpdateService->handle($user, $validated,$request->file('image'),$request->file('image_cover'));

        return response()->json(['message' => 'success',$user],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete',$user);
        $user->delete();
        return response()->json(['message' => 'success',$user],200);
    }
}
