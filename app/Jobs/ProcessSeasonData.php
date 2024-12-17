<?php

namespace App\Jobs;

use App\Models\Season;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSeasonData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunk;

    /**
     * Create a new job instance.
     *
     * @param array $chunk
     */
    public function __construct(array $chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->chunk as $seasonData) {
            Season::updateOrCreate(
                ['id' => $seasonData['id']],
                [
                    'sport_id' => $seasonData['sport_id'],
                    'league_id' => $seasonData['league_id'],
                    'tie_breaker_rule_id' => $seasonData['tie_breaker_rule_id'],
                    'name' => $seasonData['name'],
                    'finished' => $seasonData['finished'],
                    'pending' => $seasonData['pending'],
                    'is_current' => $seasonData['is_current'],
                    'standing_method' => $seasonData['standings_recalculated_at'],
                    'starting_at' => $seasonData['starting_at'],
                    'ending_at' => $seasonData['ending_at'],
                ]
            );
        }
    }
}
