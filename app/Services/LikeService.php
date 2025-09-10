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
        $type = get_class($likeable);

        $like = Like::where([
            'user_id' => $userId,
            'likeable_type' => $type,
            'likeable_id' => $likeable->id])->first();


        if ($like) {
            $likeable->likes()->where('user_id', $userId)->delete();
            $likeable->decrement('likes');
            $liked = false;
        } else {
            $likeable->likes()->create(['user_id' => $userId]);
            $likeable->increment('likes');
            $liked = true;

        }
        $count = $likeable->likes()->count();


        return ['success' => true, 'liked' => $liked, 'likes' => $count];
    }


}
