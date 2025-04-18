<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $users = User::get();
        $posts = Post::get();

        foreach ($posts as $post) {
            $userIds = $users->random(rand(1, 5))->pluck('id')->toArray();

            foreach ($userIds as $userId) {
                $post->likes()->create(['user_id' => $userId]);
                $post->increment('likes');


            }
        }


    }
}
