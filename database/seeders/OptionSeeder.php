<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all the questions
        $questions = Question::all();

        foreach ($questions as $question) {
            // Generate 4 options per question
            Option::create([
                'question_id' => $question->id,
                'option_text' => 'Option 1 text for question ' . $question->id,
                'is_correct' => false,
            ]);

            Option::create([
                'question_id' => $question->id,
                'option_text' => 'Option 2 text for question ' . $question->id,
                'is_correct' => false,
            ]);

            Option::create([
                'question_id' => $question->id,
                'option_text' => 'Option 3 text for question ' . $question->id,
                'is_correct' => true,  // Mark this as the correct answer
            ]);

            Option::create([
                'question_id' => $question->id,
                'option_text' => 'Option 4 text for question ' . $question->id,
                'is_correct' => false,
            ]);
        }
    }
}
