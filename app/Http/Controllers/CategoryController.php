<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show(Category $category)
    {

        $posts = $category->posts()->orderBy('created_at', 'DESC')->withCount(['comments', 'likes'])->get();
        return view('left_sidebar.category_show', compact('posts', 'category'));
    }

    public function my_feed()
    {

        $authors_ids = Subscribe::where('user_id', Auth::id())->pluck('author_id');
        $posts = Post::whereIn('user_id', $authors_ids)->withCount(['comments', 'likes'])->get();
        return view('left_sidebar.myFeed_show', compact('posts'));
    }

    public function newest()
    {
        $posts = Post::where('created_at', '>=', Carbon::now()->subDay())
            ->withCount(['comments', 'likes'])->get();

        return view('left_sidebar.newest_show', compact('posts'));
    }

    public function popular()
    {
        $posts = Post::orderBy('views', 'DESC')->withCount(['comments', 'likes'])->get();
        return view('left_sidebar.popular_show', compact('posts'));
    }
}
