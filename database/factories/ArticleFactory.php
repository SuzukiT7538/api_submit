<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;

class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'slug' => $this->faker->sentence(10),
            'body' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(10),
            'createdAt' => $this->faker->dateTime(),
            'updatedAt' => $this->faker->dateTime(),
            'author' => $this->faker->name(),
        ];
    }
}
