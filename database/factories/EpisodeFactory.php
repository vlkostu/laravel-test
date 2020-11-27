<?php

namespace Database\Factories;

use App\Models\Episode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::beforeLast($this->faker->sentence(3), '.'),
            'air_date' => $this->faker->dateTimeThisYear
        ];
    }
}
