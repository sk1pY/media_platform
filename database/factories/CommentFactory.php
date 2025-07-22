<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userCount = User::count();
        $postCount = Post::count();
        return [
            'text' => $this->faker->realText(),
            'user_id' => $this->faker->numberBetween(1, $userCount),
            'post_id' => $this->faker->numberBetween(1, $postCount),
        ];
    }
}
