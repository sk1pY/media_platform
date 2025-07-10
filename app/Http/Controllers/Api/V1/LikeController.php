<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likePost(Post $post, LikeService $likeService): JsonResponse
    {
        $result = $likeService->toggleLike($post, Auth::id());
        return response()->json($result);
    }

    public function likeComment(Post $post, Comment $comment, LikeService $likeService): JsonResponse
    {
        $result = $likeService->toggleLike($comment, Auth::id());
        return response()->json($result);

    }
}
