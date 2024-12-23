<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



//        for ($i=0;$i<1000;$i++){
//            $userId = User::inRandomOrder()->first()->id;
//            $postId = Post::inRandomOrder()->first()->id;
//            if(!Like::where('user_id', $userId)->where('post_id', $postId)->exists()) {
//                DB::table('likes')->insertOrIgnore([
//                    'post_id' => $postId,
//                    'user_id' => $userId,
//                ]);
//            }
//        }

        $likes = Like::factory()->count(150)->make();

        $likesData = $likes->toArray();

        DB::table('likes')->insertOrIgnore($likesData);



    }
}
