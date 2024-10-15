<?php

namespace Database\Seeders;

use App\Models\QuestionBank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuestionBank::create([
            'name' => 'Football Basics',
            'image' => 'football_basics.png',
        ]);

        QuestionBank::create([
            'name' => 'Advanced Football Knowledge',
            'image' => 'advanced_football.png',
        ]);
    }
}
