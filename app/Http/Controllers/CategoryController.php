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

//    public function my_feed()
//    {
//
//        $authors_ids = Subscribe::where('user_id', Auth::id())->pluck('author_id');
//        $posts = Post::whereIn('user_id', $authors_ids)->withCount(['comments', 'likes'])->get();
//        return view('left_sidebar.myFeed_show', compact('posts'));
//    }
//
//    public function newest()
//    {
//        $posts = Post::where('created_at', '>=', Carbon::now()->subDay())
//            ->withCount(['comments', 'likes'])->get();
//
//        return view('left_sidebar.newest_show', compact('posts'));
//    }
//
//    public function popular()
//    {
//        $posts = Post::orderBy('views', 'DESC')->withCount(['comments', 'likes'])->get();
//        return view('left_sidebar.popular_show', compact('posts'));
//    }

    public function specialCategories(Request $request, $slug)
    {
        $query = Post::query();
        $user = Auth::user();
//        $bookmarkTaskUser = Auth::check() ?
//            Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray() : null;
//        $subscribesIds = $user->subscribes()->pluck('subscribes.id');
//        dd($subscribesIds);


        match ($slug) {
            'popular' => $query->orderBy('views','desc'),
            'fresh' => $query->where('created_at','>', Carbon::now()->subDay(1))->latest(),
            'myFeed' => $query->wherein('author_id',$subscribesIds),
            default => null
        };

        $posts = $query->get();
        return view('left_sidebar.'.$slug, compact('posts'));
    }
}
