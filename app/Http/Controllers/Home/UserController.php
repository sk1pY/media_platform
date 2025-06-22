<?php

namespace App\Http\Controllers\Home;

use App\Actions\Post\FilterPosts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\UserUpdateRequest;
use App\Models\Post;
use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        //
    }


    public function show(
        User        $user,
        FilterPosts $filterPosts,
        Request     $request)
    {
        abort_if(!$user->status, 404);

        $postQuery = $user->posts()->withcount('comments');
        $filter = $request->get('filter');
        $filterPosts->execute($postQuery, $filter);
        $posts = $postQuery->get();
        $countSubAuthors = Subscribe::where('author_id', $user->id)->count();
        return view('front.user_page', compact('user', 'posts', 'countSubAuthors'));

    }

    public function edit()
    {
        $user = Auth::user();
        return view('home.profile_edit', compact('user'));

    }

    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = basename($request->file('image')->store('avatarImages', 'public'));
        }

        if ($request->hasFile('image_cover')) {
            if ($user->image_cover) {
                Storage::disk('public')->delete($user->image_cover);
            }
            $validated['image_cover'] = basename($request->file('image_cover')->store('profileСoverImages', 'public'));
        }

        $user->update($validated);

        return back()->with('success', 'Профиль успешно обновлен');

    }

    public function destroy(User $user)
    {
        $user->delete();
        return to_route('index');

    }
}
