<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
         Log::info($request->input('search'));
         Log::info($request->input('category_slug'));
        $category_slug = $request->input('category_slug');

        if ($category_slug) {

            $category = Category::where('slug', $category_slug)->first();

            if ($category) {
                $posts = Post::where('title', 'like', '%' . $request->input('search') . '%')
                    ->where('category_id', $category->id)
                    ->get();
            } else {
                $posts = collect();
            }

        } else {
            $posts = Post::where('title', 'like', '%' . $request->input('search') . '%')->get();
        }

        $html = '';
        foreach ($posts as $post) {

            $html .= view('partials.post_card', compact('post'))->render();
        }
        return response()->json(['html' => $html]);
    }

}
