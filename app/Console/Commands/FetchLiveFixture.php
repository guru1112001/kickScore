<?php

namespace App\Console\Commands;

use App\Models\LiveFixture;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessCommentariesJob;
use Illuminate\Support\Facades\Http;

class FetchLiveFixture extends Command
{
    protected $signature = 'fetch:livefixtures';
    protected $description = 'Fetch today\'s fixtures from SportMonk and store them in the database';

    public function handle()
    {
        $date = now()->format('Y-m-d');
        $baseUrl = "https://api.sportmonks.com/v3/football/fixtures/date/{$date}";
        $apiKey = config('services.sportmonks_api_token');
        $includes = 'sport:name;participants.players.position:name;formations;lineups;weatherReport;venue;timeline;trends;league:name;metadata;comments;events.type:name;events.subtype';
        
        $page = 1;
        $hasMore = true;

        while ($hasMore) {
            $response = Http::get("$baseUrl?api_token={$apiKey}&include=$includes&timezone=Asia/Kolkata&page=$page");

            if (!$response->successful()) {
                Log::error("Failed to fetch fixtures on page $page: " . $response->body());
                break;
            }

            $data = $response->json();
            $fixtures = $data['data'] ?? [];
            $pagination = $data['pagination'] ?? [];
            $hasMore = $pagination['has_more'] ?? false;
            $page++;

            foreach ($fixtures as $fixture) {
                try {
                    $liveFixture = LiveFixture::updateOrCreate(
                        ['fixture_id' => $fixture['id']],
                        [
                            'sport_id'      => $fixture['sport']['id'] ?? null,
                            'league_id'     => $fixture['league']['id'] ?? null,
                            'season_id'     => $fixture['season']['id'] ?? null,
                            'name'          => $fixture['name'] ?? null,
                            'starting_at'   => $fixture['starting_at'] ?? null,
                            'participants'  => $fixture['participants'] ?? null,
                            'weather_report'=> $fixture['weatherReport'] ?? null,
                            'venue'         => $fixture['venue'] ?? null,
                            'formations'    => $fixture['formations'] ?? null,
                            'metadata'      => $fixture['metadata'] ?? null,
                            'lineups'       => $fixture['lineups'] ?? null,
                            'timeline'      => $fixture['timeline'] ?? null,
                            'trends'        => $fixture['trends'] ?? null,
                            'comments'      => $fixture['comments'] ?? null,
                            'events'        => $fixture['events'] ?? null,
                        ]
                    );

                    // Dispatch job to fetch commentaries for each fixture
                    ProcessCommentariesJob::dispatch($liveFixture->fixture_id, collect($fixture['participants'])->pluck('id')->toArray());

                } catch (\Exception $e) {
                    Log::error("Error processing fixture: " . $e->getMessage());
                }
            }
        }

        Log::info('Live Fixtures fetched successfully.');
    }
}
