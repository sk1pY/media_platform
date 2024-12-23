<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
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
    public function index($id)
    {
        $user = User::where('id', $id)->first();
       // dd($user->image);
        $posts = Post::where('user_id', $id)->get();
        $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();
        $countSubAuthors = Subscribe::where('author_id', $id)->count();


        return view('home', compact('user', 'posts','subAuthors','countSubAuthors'));

    }

    public function update_post(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
     //   dd($validatedData);
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
        $post->update($validatedData + ['user_id' => Auth::id()]);
            return redirect('/home/'.Auth::id());
    }

    public function update_profile(Request $request, $id)
    {
        $user = User::findOrFail($id);
       // dd($user);
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:50',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            if ($request->hasFile('image')) {
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }

                $imagePath = $request->file('image')->store('images', 'public');


                $validatedData['image'] = $imagePath;
            } else {
                unset($validatedData['image']);
            }
        $user->update($validatedData);

        return redirect('/home/'.Auth::id());

    }

    public function destroy($id)
    {
        Post::find($id)->delete();

        return redirect('/home/'.Auth::id());
    }
}
