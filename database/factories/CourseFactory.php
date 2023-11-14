<?php

namespace Database\Factories;

use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
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
            'description' => $this->faker->realText(),
            'start_date' => $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => Carbon::instance($startDate)->addMonths(rand(1, 6)),
            'image' => $this->createImage()
        ];
    }

    public function createImage(): ?string
    {
        try {
            $image = file_get_contents('https://source.unsplash.com/random/200x200/?education');
        } catch (Throwable $exception) {
            return null;
        }

        $filename = Str::uuid() . '.jpg';

        Storage::disk('public')->put($filename, $image);

        return $filename;
    }
}
