<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PollSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\OptionSeeder;
use Database\Seeders\FanPhotoSeeder;
use Database\Seeders\QuestionSeeder;
use Database\Seeders\PollOptionSeeder;
use Database\Seeders\AnnouncementSeeder;
use Database\Seeders\QuestionBankSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // QuestionBankSeeder::class,
            // QuestionSeeder::class,
            // OptionSeeder::class,
            // PollSeeder::class,
            // PollOptionSeeder::class,
            // AnnouncementSeeder::class,
            // UserSeeder::class,
            FanPhotoSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
