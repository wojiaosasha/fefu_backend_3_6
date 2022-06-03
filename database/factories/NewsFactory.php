<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'published_at' =>
                $this->faker->boolean ?
                    $this->faker->dateTimeBetween('-2 week', '+2 week') : null ,
            'title' => $this->faker->realTextBetween(20, 30),
            'text' => $this->faker->realTextBetween(250, 1000),
        ];
    }
}
