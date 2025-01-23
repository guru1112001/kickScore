<?php

namespace App\Console\Commands;

use App\Models\LiveFixture;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchLiveFixture extends Command
{
    protected $signature = 'fetch:livefixtures';
    protected $description = 'Fetch today\'s fixtures from SportMonk and store them in the database';

    public function handle()
    {
        $apiUrl = 'https://api.sportmonks.com/v3/football/fixtures';
        $apiKey = config('services.sportmonks_api_token');
        $includes = 'sport:name;participants.players.position:name;formations;lineups;weatherReport;venue;timeline;trends;league:name;metadata;comments;events.type:name;events.subtype';

        $response = Http::get("$apiUrl?api_token={$apiKey}&filter=todayDate&include=$includes&timezone=Asia/Kolkata");

        if ($response->successful()) {
            $fixtures = $response->json()['data'];

            foreach ($fixtures as $fixture) {
                // if (empty($fixture['id']) || !is_numeric($fixture['id'])) {
                //     $this->error('Invalid fixture ID. Skipping...');
                //     continue;
                // }

                // $fixtureId = (int)$fixture['id'];
                // $this->info('Processing fixture ID: ' . $fixtureId);

                // try {
                    LiveFixture::updateOrCreate(
                        ['fixture_id' => $fixture['id']],
                        [
                            'sport_id' => $fixture['sport_id'] ?? null,
                            'league_id' => $fixture['league_id'] ?? null,
                            'season_id' => $fixture['season_id'] ?? null,
                            'name' => $fixture['name'] ?? null,
                            'starting_at' => $fixture['starting_at'] ?? null,
                            'length'=>$fixture['length'] ?? null,
                            'details' => $fixture['details'] ?? null,
                            'participants' => $fixture['participants'] ?? null,
                            'weather_report' => $fixture['weatherreport'] ?? null,
                            'venue' => $fixture['venue'] ?? null,
                            'formations' => $fixture['formations'] ?? null,
                            'metadata' => $fixture['metadata'] ?? null,
                            'lineups' => $fixture['lineups'] ?? null,
                            'timeline' => $fixture['timeline'] ?? null,
                            'trends' => $fixture['trends'] ?? null,
                            'comments' => $fixture['comments'] ?? null,
                            'events' => $fixture['events'] ?? null,
                        ]
                    );
                // } catch (\Exception $e) {
                //     $this->error('Error processing fixture: '. $e->getMessage());
                // }
                
            }

            $this->info('Fixtures fetched and stored successfully.');
        } else {
            $this->error('Failed to fetch fixtures. Response: ' . $response->body());
        }
    }
}
