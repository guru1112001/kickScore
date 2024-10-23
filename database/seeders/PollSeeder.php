<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polls = [
            [
                'title' => 'Best Football Player of the Year', 
                'description' => 'Who do you think is the best football player of this year?',
                'options' => ['Lionel Messi', 'Cristiano Ronaldo', 'Kylian Mbappé', 'Erling Haaland']
            ],
            [
                'title' => 'Best Football Team', 
                'description' => 'Which football team do you think is the best?',
                'options' => ['Real Madrid', 'Manchester City', 'Barcelona', 'Bayern Munich']
            ],
            [
                'title' => 'Football World Cup Winner', 
                'description' => 'Which country will win the next Football World Cup?',
                'options' => ['Argentina', 'Brazil', 'Germany', 'France']
            ],
            [
                'title' => 'Top Goal Scorer', 
                'description' => 'Who will be the top goal scorer this season?',
                'options' => ['Robert Lewandowski', 'Harry Kane', 'Mohamed Salah', 'Karim Benzema']
            ],
            [
                'title' => 'Best Football League', 
                'description' => 'Which football league is the best in the world?',
                'options' => ['Premier League', 'La Liga', 'Serie A', 'Bundesliga']
            ],
            [
                'title' => 'Best Football Coach', 
                'description' => 'Who is the best football coach currently?',
                'options' => ['Pep Guardiola', 'Jurgen Klopp', 'Carlo Ancelotti', 'Diego Simeone']
            ],
            [
                'title' => 'Most Exciting Football Match', 
                'description' => 'Which football match was the most exciting to watch?',
                'options' => ['El Clásico', 'Manchester Derby', 'Milan Derby', 'North London Derby']
            ],
            [
                'title' => 'Most Valuable Football Player', 
                'description' => 'Who is the most valuable football player right now?',
                'options' => ['Kylian Mbappé', 'Erling Haaland', 'Vinícius Júnior', 'Jude Bellingham']
            ],
            [
                'title' => 'Best Football Goalkeeper', 
                'description' => 'Who is the best goalkeeper in football?',
                'options' => ['Thibaut Courtois', 'Alisson Becker', 'Ederson', 'Manuel Neuer']
            ],
            [
                'title' => 'Best Football Stadium', 
                'description' => 'Which football stadium is the best for fans?',
                'options' => ['Camp Nou', 'Wembley Stadium', 'Santiago Bernabéu', 'Allianz Arena']
            ]
        ];

        foreach ($polls as $pollData) {
            $poll = Poll::create([
                'title' => $pollData['title'],
                'description' => $pollData['description'],
            ]);

            // Seeding related football-specific poll options
            foreach ($pollData['options'] as $optionText) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'option' => $optionText,
                ]);
            }
        }
    }
}
