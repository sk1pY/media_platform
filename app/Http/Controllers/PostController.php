<?php

namespace App\Http\Controllers;

use App\Actions\Post\FilterPosts;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HiddenPost;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request     $request,
        FilterPosts $filterPosts)
    {
        $categories = Category::get();
        $postQuery = Post::where('status', 1)->withCount(['comments', 'likes']);
        if (Auth::check()) {
            $hiddenPostIds = HiddenPost::where('user_id', Auth::id())->pluck('post_id')->toArray();
            $postQuery->wherenotin('id', $hiddenPostIds);
        }

        $filter = $request->get('filter');
        $filterPosts->execute($postQuery, $filter);

        $posts = $postQuery->paginate(5);

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

    public function incrementViews(Post $post): JsonResponse
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
    public function show(Request $request, Post $post): View
    {
        abort_if(!$post->status, 404);

        $commentsQuery = $post->comments()->latest();
        //кол-во коментов под постом
        $post->loadCount(['comments']);

        if ($request->filled('filter')) {
            match ($request->input('filter')) {
                'recent' => $commentsQuery->latest(),
                'old' => $commentsQuery->oldest(),
                'popular' => $commentsQuery->orderBy('likes', 'desc'),
                default => $commentsQuery->latest(),
            };
        }
        $comments = $commentsQuery->get();
        $postShowFlag = true;

        return view('front.post', compact('post', 'comments', 'postShowFlag'));
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
