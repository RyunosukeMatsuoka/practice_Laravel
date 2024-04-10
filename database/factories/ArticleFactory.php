<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->realTextBetween(5, 20),
            "outline" => fake()->realTextBetween(10,100),
            "content" => fake()->realTextBetween(30,200),
            'user_id' => fake()->numberBetween(1, User::count()),
        ];
    }
}
