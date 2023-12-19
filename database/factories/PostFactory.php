<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(60),
            'body' => $this->faker->realText(1400),
            'is_active' => $this->faker->boolean,
            'published_at' => $this->faker->dateTimeThisYear(),
            'author_id' => User::factory(),
        ];
    }
}
