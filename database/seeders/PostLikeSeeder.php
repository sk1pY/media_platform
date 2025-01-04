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


        $users = User::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            $userIds = $users->random(rand(1, 5))->pluck('id')->toArray();

            foreach ($userIds as $userId) {
                $post->likes()->create(['user_id' => $userId,'is_liked' => true]);
                $post->increment('likes');


            }
        }


    }
}
