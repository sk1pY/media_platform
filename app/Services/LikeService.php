<?php

namespace App\Services;


use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LikeService
{

    public function toggleLike(Model $likeable, $userId)
    {
        $like = $likeable->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            $likeable->decrement('likes'); // Обновило запись в БД
            $liked = false;
        } else {
            $likeable->likes()->create(['user_id' => $userId]);
            $likeable->increment('likes'); // Обновило запись в БД
            $liked = true;
        }


        $likeable->refresh();

        return [
            'success' => true,
            'liked'   => $liked,
            'likes'   => (int) $likeable->likes
        ];
    }


}
