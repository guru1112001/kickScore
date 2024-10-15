<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PollOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polls = Poll::all();

        foreach ($polls as $poll) {
            for ($j = 1; $j <= 4; $j++) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'option' => 'Option ' . $j . ' for Poll ' . $poll->id,
                ]);
            }
        }
    }
}
