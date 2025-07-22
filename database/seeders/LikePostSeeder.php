<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Like::factory()->count(700)->create();

        Post::query()->each(function ($post) {
            $post->update([
                'likes' => $post->likes()->count(),
            ]);
        });


    }
}
