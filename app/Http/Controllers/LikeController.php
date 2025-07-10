<?php

// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\LikeService;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

// Добавлено для использования модели Task

class LikeController extends Controller
{

    public function likePost(Request $request, LikeService $likeService): \Illuminate\Http\JsonResponse
    {

        $postId = $request->input('post_id');
        $post = Post::find($postId);

        // $this->authorize('like', $post);

        $result = $likeService->toggleLike($post, Auth::id());
        return response()->json($result);
    }

    public function likeComment(Request $request, LikeService $likeService): \Illuminate\Http\JsonResponse
    {
        //  Log::info($request->input('comment_id'));
        $commentId = request('comment_id');
        $comment = Comment::find($commentId);

        $result = $likeService->toggleLike($comment, Auth::id());

        return response()->json($result);
    }
}



