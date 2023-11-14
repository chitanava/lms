<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('public');

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Course::factory()
            ->count(mt_rand(1, 4))
            ->create()
            ->each(function ($course) {
                \App\Models\Topic::factory()
                    ->count(mt_rand(5, 10))
                    ->for($course)
                    ->create()
                    ->each(function ($topic) {
                        \App\Models\Lesson::factory()
                            ->count(mt_rand(5, 10))
                            ->for($topic)
                            ->create();
                    });
            });
    }
}
