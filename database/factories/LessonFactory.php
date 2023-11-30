<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->unique()->sentence(),
            'slug' => Str::slug($title),
            'is_visible' => $this->faker->boolean(),
            'components' => $this->generateComponents(),
        ];
    }

    protected function generateComponents(): array
    {
        return
            [
                [
                    'data' => [
                        'title' => $this->faker->unique()->sentence(),
                        'content' => $this->faker->realText()
                    ],
                    'type' => 'paragraph'
                ],
                [
                    'data' => [
                        'title' => $this->faker->unique()->sentence(),
                        'items' =>
                            [
                                [
                                    'heading' => $this->faker->unique()->sentence(),
                                    'description' => $this->faker->realText()
                                ],
                                [
                                    'heading' => $this->faker->unique()->sentence(),
                                    'description' => $this->faker->realText()
                                ]
                            ]
                    ],
                    'type' => 'accordion'
                ]
            ];
    }
}
