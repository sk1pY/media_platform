<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\PostStoreRequest;
use App\Http\Requests\Home\PostUpdateRequest;
use App\Models\HiddenPost;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = auth()->user()->posts()->with('comments', 'likes')->latest()->get();
        $user = Auth::user();
        return view('home.posts', compact('posts', 'user'));
    }

    public function hiddenPosts()
    {
        $postsIds = HiddenPost::where(['user_id' => Auth::id()])->pluck('post_id');
        $posts = Post::whereIn('id', $postsIds)->withCount(['comments', 'likes'])->latest()->get();
        $flag = true;
        return view('home.hidden_posts', compact('posts', 'flag'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {
//        $this->authorize('create', Post::class);

        $validated = $request->validated();

        $validated['image'] = $request->hasfile('image') ?
            basename($request->file('image')->store('postImages', 'public')) :
            null;

        Auth::user()->posts()->create($validated);

        return to_route('index')->with('success', 'Пост успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post):RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->hasfile('image') ? basename($request->file('image')->store('postImages', 'public')) : null;

        }
        $post->update($validated);
        return back()->with('success', 'Пост успешно обновлен');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post):RedirectResponse
    {
        $this->authorize('destroy', $post);

        $post->delete();
        return back()->with('success', 'Пост успешно удален.');
    }
}
