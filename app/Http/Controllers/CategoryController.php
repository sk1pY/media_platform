<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Request $request,Category $category):view
    {
        $postQuery = $category->posts()->where('status', 1)->withCount(['comments', 'likes']);
        $posts = $postQuery->filterBy($request)->get();

        return view('front.left_sidebar.category_show', compact('posts', 'category'));
    }


    public function specialCategories(Request $request, $slug):view
    {
        $query = Post::query();
        $user = Auth::user();
        $subscriptionsIds = Auth::check()?$user->subscribes()->pluck('author_id'):null;
        match ($slug) {
            'popular' => $query->orderBy('views', 'desc'),
            'fresh' => $query->where('created_at', '>', Carbon::now()->subDay(1))->latest(),
            'myFeed' => $query->wherein('user_id', $subscriptionsIds),
            default => null
        };

        $posts = $query->filterBy($request)->get();
        return view('front.left_sidebar.special_category_show',compact('posts','slug'));
    }
}
