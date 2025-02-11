<?php

namespace App\Jobs;

use App\Models\Fixture;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFixtureData implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $fixtureData;

    public function __construct(array $fixtureData)
    {
        $this->fixtureData = $fixtureData;
    }

    public function handle()
    {
        foreach ($this->fixtureData as $fixture) {
            Fixture::updateOrCreate(
                ['id' => $fixture['id']],
                [
                    'sport_id' => $fixture['sport_id'],
                    'league_id' => $fixture['league_id'],
                    'season_id' => $fixture['season_id'],
                    'stage_id' => $fixture['stage_id'],
                    'group_id' => $fixture['group_id'] ?? null,
                    'aggregate_id' => $fixture['aggregate_id'] ?? null,
                    'state_id' => $fixture['state_id'],
                    'round_id' => $fixture['round_id'] ?? null,
                    'venue_id' => $fixture['venue_id'] ?? null,
                    'name' => $fixture['name'] ?? null,
                    'starting_at' => $fixture['starting_at'] ?? null,
                    'result_info' => $fixture['result_info'] ?? null,
                    'leg' => $fixture['leg'] ?? null,
                    'details' => $fixture['details'] ?? null,
                    'length' => $fixture['length'] ?? null,
                    'participants' => $fixture['participants'],
                ]
            );
        }

        Log::info('Processed ' . count($this->fixtureData) . ' fixtures.');
    }
}
