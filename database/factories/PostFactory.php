<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Link to User
            'caption' => $this->faker->sentence,
            'image' => 'https://cache.lahelu.com/image-Pexu4Pa2a-30098',
            'video' => '', // Keep video empty
            'like' => $this->faker->numberBetween(0, 100),
            'unlike' => $this->faker->numberBetween(0, 10),
            'is_sensitive' => $this->faker->boolean,
            'is_onrule' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
