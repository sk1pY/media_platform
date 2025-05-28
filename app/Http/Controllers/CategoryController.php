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


    public function specialCategories(Request $request, $slug)
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
//        $slugTitles = [
//            'popular' => 'Популярное',
//            'fresh' => 'Свежее за 24 часа',
//            'myFeed' => 'Моя лента',
//        ];
//        $slug = $slugTitles[$slug];
        $posts = $query->get();
        return view('left_sidebar.special_category_show',compact('posts','slug'));
    }
}
