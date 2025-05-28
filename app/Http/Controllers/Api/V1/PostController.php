<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortColumn = $request->input('sort', 'id');
        if (empty($sortColumn)) {
            $sortColumn = 'id';
        }
        $sortDirection = str_starts_with($sortColumn, '-') ? 'desc' : 'asc';
        $sortColumn = ltrim($sortColumn, '-');


        $query = Post::query();
        $query->when($request->filled('category'), function ($query) use ($request) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->input('category'));
            });
        });

        $posts = $query->with('category')->orderBy($sortColumn, $sortDirection)->paginate(10);

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('postImages', 'public');
            $fileName = basename($path);
        }
        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'likes' => 0,
            'views' => 0,
            'user_id' => $user->id,
            'image' => $fileName
        ]);


        return response()->json(['message' => 'Good'], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete('postImages/' . $post->image);
            }

            $path = $request->file('image')->store('postImages', 'public');
            $validatedData['image'] = basename($path);
        }

         $post->update($validatedData);

        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
