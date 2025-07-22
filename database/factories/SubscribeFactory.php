<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscribeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = $this->faker->numberBetween(1, 15);
        $authorId = $this->faker->numberBetween(1, 15);

        while($userId === $authorId){
            $authorId = $this->faker->numberBetween(1, 15);
        }

        return [
            'user_id' => $userId,
            'author_id' => $authorId
        ];
    }
}
