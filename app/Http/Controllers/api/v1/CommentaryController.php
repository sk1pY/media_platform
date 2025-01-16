<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
       $posts =  $post->comments()->get();

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Post $post)
    {
        $user = Auth::user();
        if(!$user){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

      $comments =   Comment::create([
            'text' => $request->input('text'),
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        return response()->json(['message' => 'success',$comments],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function destroy(Comment $comment)
    {
        $comment->delete();
            return response()->json(['message' => 'success']);
  }
}
