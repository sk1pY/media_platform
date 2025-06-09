<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
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

    }


    public function show(User $user)
    {
        if (!$user->status) {
            abort(404, 'error.error');
        }

        $posts = $user->posts()->filterBy(request())->withcount('comments')->get();
        $countSubAuthors = Subscribe::where('author_id', $user->id)->count();
        return view('front.user_page', compact('user', 'posts', 'countSubAuthors'));

    }

    public function edit()
    {
        $user = Auth::user();
        return view('home.profile_edit', compact('user'));

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'sometimes|alpha_num|filled|unique:users,name,' . $user->id,
            'image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_cover' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
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
