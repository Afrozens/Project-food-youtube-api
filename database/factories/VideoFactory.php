<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Video;
use App\Models\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'code' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Video $video) {
        })->afterCreating(function (Video $video) {
            $number_rand = rand(2, 5);
            $tags = Tag::inRandomOrder()->take($number_rand)->get();
            $video->tags()->attach($tags);
        });
    }
}
