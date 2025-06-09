<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\HiddenPost;
use App\Models\Post;
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
        return view('home.hidden_posts', compact('posts','flag'));
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
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|max:100|alpha_dash|unique:posts,title',
            'description' => 'required|max:2200',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable|numeric|exists:categories,id',
        ]);

        $validated['image'] = $request->hasfile('image') ?
            basename($request->file('image')->store('postImages', 'public')) : null;

        try {
            Auth::user()->posts()->create($validated);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Ошибка создания поста');
        }

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
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $validated = $request->validate([
            'title' => 'required|alpha_dash|max:50',
            'description' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->hasfile('image') ? basename($request->file('image')->store('postImages', 'public')) : null;

        }
        try {
            $post->update($validated);
            return back()->with('success', 'Пост успешно обновлен.');

        } catch (\Throwable $e) {
            Log::error('<UNK> <UNK> <UNK>: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);

        $post->delete();
        return back()->with('success', 'Пост успешно удален.');
    }
}
