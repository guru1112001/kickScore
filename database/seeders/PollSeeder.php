<?php

namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Poll::create([
                'title' => 'Poll Title ' . $i,
                'description' => 'This is the description for Poll ' . $i,
            ]);
        }
    }
}
