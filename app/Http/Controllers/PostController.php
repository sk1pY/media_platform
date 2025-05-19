<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
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
    public function index(Request $request)
    {
        $categories = Category::get();
        $postQuery = Post::where('status', 1)->withCount(['comments', 'likes'])->orderBy('created_at', 'desc');

        if (Auth::check()) {
            $hiddenPostIds = HiddenPost::where('user_id', Auth::id())->pluck('post_id')->toArray();
            $postQuery->wherenotin('id', $hiddenPostIds);
        }
        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'popular':
                    $postQuery->orderBy('views', 'desc');
                    break;
                case 'recent':
                    $postQuery->orderBy('created_at', 'desc');
                    break;
                case 'old':
                    $postQuery->orderBy('created_at', 'asc');
            }
        }

        $posts = $postQuery->get();
        return view('index', compact('posts', 'categories'));
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
            'title' => 'required|max:100',
            'description' => 'required|max:500',
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
    public function show(Request $request, Post $post)
    {
        if (!$post->status) {
            abort(404, 'error.error');
        }

        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->get();

        $post = Post::withCount(['comments', 'likes'])->find($post->id);
        if ($request->filled('filter')) {
            $query = Comment::query();

            match ($request->input('filter')) {
                'recent' => $query->latest(),
                'old' => $query->oldest(),
                'popular' => $query->orderBy('likes', 'desc'),
            };

            $comments = $query->get();
        }


        return view('about_task', compact('post', 'comments'));
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
        $user = Auth::user();
        $validated = $request->validate([
            'title' => 'required|string|max:50',
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
            $user->posts()->update($validated);
            return redirect()->back()->with('success', 'Пост успешно обновлен.');

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
        return redirect()->back()->with('success', 'Пост успешно удален.');
    }


//    ----------------------------------------------------------------------------------

    public function hide(Request $request, Post $post)
    {
        $this->authorize('hidden_posts', $post);

        if ($request['hidden']) {
            $hiddenPost = HiddenPost::where(['user_id' => Auth::id(), 'post_id' => $post->id])->first();
            if ($hiddenPost) {
                $post->hiddenPosts()->detach(Auth::id());
                return redirect()->back()->with('success', 'Пост успешно вернулся в ленту');

            } else {
                $post->hiddenPosts()->attach(Auth::id());
                return redirect()->back()->with('success', 'Пост успешно скрыт');

            }
        }
    }

    public function hidden_posts()
    {
        $postsIds = HiddenPost::where(['user_id' => Auth::id()])->pluck('post_id');
        $posts = Post::whereIn('id', $postsIds)->withCount(['comments', 'likes'])->get();
        $flag = true;
        return view('dashboard.hidden_posts', compact('posts','flag'));
    }

    public function f(Request $request, Post $post)
    {

    }

    public function incrementViews(Post $post)
    {
        $post->increment('views');
        return response()->json(['success' => true, 'views' => $post->views]);
    }

    public function profilePosts()
    {
        $posts = auth()->user()->posts()->with('comments', 'likes')->latest()->get();
        $user = Auth::user();
        return view('dashboard.posts', compact('posts', 'user'));
    }
}
