<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $posts = Post::where('user_id', $id)->get();
        $countSubAuthors = Subscribe::where('author_id', $id)->count();

        return view('home', compact('user', 'posts','countSubAuthors'));

    }

    public function update_post(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('postImages', 'public');
            $fileName = basename($path);
            $validatedData['image'] = $fileName;
        } else {
            unset($validatedData['image']);
        }
        $post->update(array_merge($validatedData, ['user_id' => Auth::id()]));
            return redirect()->route('home.profile.show',Auth::id());
    }

    public function update_profile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:50',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_cover' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            if ($request->hasFile('image') ) {
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }

                $imagePath = $request->file('image')->store('avatarImages', 'public');
                $fileName = basename($imagePath);

                $validatedData['image'] = $fileName;
            } else {
                unset($validatedData['image']);
            }

        if ($request->hasFile('image_cover') ) {
            if ($user->image_cover) {
                Storage::disk('public')->delete($user->image_cover);
            }

            $imagePath = $request->file('image_cover')->store('profile_cover_images', 'public');
            $fileName = basename($imagePath);

            $validatedData['image_cover'] = $fileName;
        } else {
            unset($validatedData['image_cover']);
        }
        $user->update($validatedData);

            return redirect()->back();

    }

    public function destroy($id)
    {
        Post::find($id)->delete();

        return redirect('/home/'.Auth::id());
    }
}
