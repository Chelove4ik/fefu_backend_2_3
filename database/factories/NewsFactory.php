<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique->text,
            'text' => $this->faker->text,
            'is_published' => $this->faker->boolean(70),
            'published_at' => $this->faker->dateTimeInInterval('-2 months', 'now'),
            'created_at' => $this->faker->dateTimeInInterval('-2 months', 'now'),
            'updated_at' => $this->faker->dateTimeInInterval('-2 months', 'now'),
        ];
    }
}