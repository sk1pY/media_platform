<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       static $commentCount, $postCount,$userCount;

       $types = [Comment::class, Post::class];
       $type = $this->faker->randomElement($types);
        $userCount = $userCount ?? User::count();

       if($type === Comment::class) {
           $commentCount = $commentCount ?? Comment::count();
           $id = $this->faker->numberBetween(1,$commentCount);
       }else{
           $postCount = $postCount ?? Post::count();
           $id = $this->faker->numberBetween(1,$postCount);
       }

       return [
           'user_id' => $this->faker->numberBetween(1,$userCount),
           'likeable_type' => $type,
           'likeable_id' => $id,
       ];
    }



}
