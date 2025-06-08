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
        $postQuery = Post::where('status', 1)->withCount(['comments', 'likes']);
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
        }else{
            $postQuery->latest();
        }


        $posts = $postQuery->get();

        return view('front.index', compact('posts', 'categories'));
    }

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
                return back()->with('success', 'Пост успешно скрыт');

            }
        }
    }

    public function incrementViews(Post $post)
    {
        $post->increment('views');
        return response()->json(['success' => true, 'views' => $post->views]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if (!$post->status) {
            abort(404, 'error.error');
        }

        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->paginate(6);

        $post->loadCount(['comments']);

        if ($request->filled('filter')) {
            $queryComment = Comment::query();

            match ($request->input('filter')) {
                'recent' => $queryComment->latest(),
                'old' => $queryComment->oldest(),
                'popular' => $queryComment->orderBy('likes', 'desc'),
            };

            $comments = $queryComment->paginate(6);
        }


        return view('front.post', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }

}
