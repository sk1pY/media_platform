<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Category::all());
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
    public function show(Category $category)
    {
        $posts = $category->posts()->latest()->get();
        return response()->json($posts);
    }
    public function specialCategoriesShow($category)
    {
       $query = Post::query();
        match ($category) {
            'popular' => $query->orderBy('views', 'desc'),
            'fresh' => $query->where('created_at', '>', Carbon::now()->subDay(1))->latest(),
          //  'myFeed' => $query->wherein('user_id', $subscriptionsIds),
            default => null
        };

        $posts = $query->get();
        return response()->json($posts);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
