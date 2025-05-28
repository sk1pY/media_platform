<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $category_slug = $request->input('category_slug');
        $special_categories = ['popular', 'fresh', 'myFeed'];
        $query = Post::query();

        if (in_array($category_slug, $special_categories)) {
            match ($category_slug) {
                'popular' => $query->orderBy('views', 'desc'),
                'fresh' => $query->where('created_at', '>', Carbon::now()->subDay(1))->latest(),
                'myFeed' => $query->wherein('user_id', $subscriptionsIds),
                default => null
            };
            $posts = $query->where('title', 'like', '%' . $request->input('search') . '%')->get();

        } elseif ($category_slug) {
            $category = Category::where('slug', $category_slug)->first();

            if ($category) {
                $posts = $query->where('title', 'like', '%' . $request->input('search') . '%')
                    ->where('category_id', $category->id)
                    ->get();
            } else {
                $posts = collect();
            }

        } else {
            $posts = $query->where('title', 'like', '%' . $request->input('search') . '%')->latest()->get();

        }

        $html = '';
        foreach ($posts as $post) {
            $html .= view('partials.post_card', compact('post'))->render();
        }

        return response()->json(['html' => $html]);
    }
}
