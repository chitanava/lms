<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\User;
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

        $this->call([
            ShieldSeeder::class,
        ]);

        User::factory(4)->create();

        User::factory()->create([
            'first_name' => 'Nika',
            'last_name' =>'Chitanava',
            'email' => 'chitanava@gmail.com',
            'password' => 'root',
            'filament_user' => 1,
        ])
            ->roles()
            ->attach(1);

        Course::factory()
            ->count(mt_rand(1, 4))
            ->state(fn(array $attributes) => [
                'author_id' => User::all()->random()->id
            ])
            ->create()
            ->each(function ($course) {
                Topic::factory()
                    ->count(mt_rand(5, 10))
                    ->for($course)
                    ->create()
                    ->each(function ($topic) {
                        Lesson::factory()
                            ->count(mt_rand(5, 10))
                            ->for($topic)
                            ->create();
                    });
            });

        $this->command->info('Database Seeding Completed.');
    }
}
