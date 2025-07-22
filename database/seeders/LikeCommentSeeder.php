<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Like::factory()->count(700)->create();

        Comment::query()->each(function ($comment) {
            $comment->update([
                'likes' => $comment->likes()->count(),
            ]);
        });
    }
}
