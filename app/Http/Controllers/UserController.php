<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(){
//       $posts = Auth::user()->posts()->get();
//       $user = Auth::user();
//        return view('dashboard.posts',compact('posts','user'));
    }


    public function show(User $user)
    {
        $posts = $user->posts()->get();
        $countSubAuthors = Subscribe::where('author_id', $user->id)->count();

        return view('home', compact('user', 'posts', 'countSubAuthors'));

    }
    public function edit(User $user)
    {
        return view('dashboard.profile_edit', compact('user'));

    }

    public function update(Request $request, User $user)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:users,name,'.$user->id,
            'email' => 'required|string|max:50|unique:users,email,'.$user->id,
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_cover' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $validatedData['image'] = $request->hasFile('image') ?
                basename($request->file('image')->store('avatarImages', 'public')) : null;
        }

        if ($request->hasFile('image_cover')) {
            if ($user->image_cover) {
                Storage::disk('public')->delete($user->image_cover);
            }
            $validatedData['image_cover'] = $request->hasFile('image_cover') ? basename($request->file('image_cover')->store('profileСoverImages', 'public')) : null;
        }
        $user->update($validatedData);

        return to_route('users.show', $user)->with('success', 'Профиль успешно обновлен');

    }
}
