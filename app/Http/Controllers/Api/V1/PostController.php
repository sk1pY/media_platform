<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\PostUpdateRequest;
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

        $posts = $query->with('category')->orderBy($sortColumn, $sortDirection)->get();

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
        $post = Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'user_id' => $user->id,
            'image' => $fileName
        ]);


        return response()->json(['message' => 'Good', $post], 201);


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
    public function update(PostUpdateRequest $request, Post $post)
    {
        // В методе контроллера
        Log::info('Request data:', $request->all());

        $validated = $request->validated();


        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete('postImages/' . $post->image);
            }

            $path = $request->file('image')->store('postImages', 'public');
            $validated['image'] = basename($path);
        }

        $post->update($validated);

        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
