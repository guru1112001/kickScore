<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = QuestionBank::all();

        // Football-related questions
        $questions = [
            'What is the standard duration of a football match?',
            'How many players are on a football team?',
            'What is a hat-trick?',
            'What is the offside rule?',
            'Who won the FIFA World Cup 2018?',
            'What is the size of a football field?',
            'What is the role of a goalkeeper?',
            'How many referees are on the field in a football match?',
            'What does VAR stand for in football?',
            'What is a penalty kick?',
            'What is the weight of a standard football?',
            'Which country has won the most FIFA World Cups?',
            'What is a yellow card?',
            'What is a red card?',
            'How long is each half in football?',
            // Add more questions as needed (total 50 per question bank)
        ];

        foreach ($banks as $bank) {
            foreach ($questions as $question) {
                Question::create([
                    'question_bank_id' => $bank->id,
                    'question_text' => $question,
                    // 'points' => rand(1, 10), // Assign random points
                ]);
            }
        }
    
    }
}
