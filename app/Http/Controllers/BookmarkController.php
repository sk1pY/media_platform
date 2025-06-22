<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():view
    {
        $bookmarks = Bookmark::with('user', 'post')->get();
        return view('home.bookmarks', compact('bookmarks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store():JsonResponse
    {
        $postId = request('post_id');
        $post = Post::find($postId);
        $this->authorize('bookmark', $post);
        $bookmark = Bookmark::where(['user_id' => auth()->id(), 'post_id' => $postId])->first();
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmarkStore' => false]);
        }
        Bookmark::create([
            'user_id' => auth()->id(),
            'post_id' => $postId]);

        return response()->json(['success' => true, 'bookmarkStore' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy()
    {
       //
    }
}
