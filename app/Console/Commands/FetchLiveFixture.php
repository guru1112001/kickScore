<?php

namespace App\Console\Commands;

use App\Models\LiveFixture;
use App\Models\Fixture;
use App\Models\Commentary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $allFixtures = [];

        while ($hasMore) {
            $response = Http::get("$baseUrl?api_token={$apiKey}&include=$includes&timezone=Asia/Kolkata&page=$page");

            if (!$response->successful()) {
                $errorMessage = 'Failed to fetch fixtures on page ' . $page . '. Response: ' . $response->body();
                $this->error($errorMessage);
                Log::error($errorMessage);
                break;
            }

            $data = $response->json();
            $currentFixtures = $data['data'] ?? [];
            $allFixtures = array_merge($allFixtures, $currentFixtures);

            $pagination = $data['pagination'] ?? [];
            $hasMore = $pagination['has_more'] ?? false;

            $page++;
        }

        if (!empty($allFixtures)) {
            foreach ($allFixtures as $fixture) {
                try {
                    $participants = $fixture['participants'] ?? [];
                    $modifiedData = $this->addCommentary($fixture, $participants);

                    LiveFixture::updateOrCreate(
                        ['fixture_id' => $fixture['id']],
                        [
                            'sport_id' => $modifiedData['sport_id'] ?? null,
                            'league_id' => $modifiedData['league_id'] ?? null,
                            'season_id' => $modifiedData['season_id'] ?? null,
                            'name' => $modifiedData['name'] ?? null,
                            'starting_at' => $modifiedData['starting_at'] ?? null,
                            'length' => $modifiedData['length'] ?? null,
                            'details' => $modifiedData['details'] ?? null,
                            'participants' => $modifiedData['participants'] ?? null,
                            'weather_report' => $modifiedData['weatherreport'] ?? null, // Fixed key
                            'venue' => $modifiedData['venue'] ?? null,
                            'formations' => $modifiedData['formations'] ?? null,
                            'metadata' => $modifiedData['metadata'] ?? null,
                            'lineups' => $modifiedData['lineups'] ?? null,
                            'timeline' => $modifiedData['timeline'] ?? null,
                            'trends' => $modifiedData['trends'] ?? null,
                            'comments' => $modifiedData['comments'] ?? null,
                            'events' => $modifiedData['events'] ?? null,
                            'commentaries' => $modifiedData['commentaries'] ?? null,
                        ]
                    );

                } catch (\Exception $e) {
                    $this->error('Error processing fixture: '. $e->getMessage());
                    Log::error('Fixture processing error: '. $e->getMessage());
                }
            }

            $this->info('Fixtures fetched and stored successfully.');
        } else {
            $this->info('No fixtures found for today.');
            Log::info('No fixtures found for today.');
        }
    }

    private function addCommentary($data, $participants)
    {
        try {
            $participantNames = collect($participants)->pluck('name')->filter()->toArray();
            
            Log::debug('STEP 1 - Participant names:', $participantNames);
            
            if (!empty($participantNames)) {
                $query = Fixture::query();
                foreach ($participantNames as $name) {
                    $cleanName = trim($name);
                    $query->orWhere('name', 'LIKE', "%{$cleanName}%");
                }
    
                $sql = $query->toSql();
                $bindings = $query->getBindings();
                
                Log::debug('STEP 2 - Generated SQL:', [$sql, $bindings]);
                
                // STEP 3: Get the SportMonks fixture IDs from the fixtures table
                $fixtureIds = $query->distinct()
                    ->pluck('id') // Since `id` = SportMonks `fixture_id` in your DB
                    ->toArray();
    
                Log::debug('STEP 3 - Found Fixture IDs:', $fixtureIds);
                
                // STEP 4: Fetch commentaries using the SportMonks fixture IDs
                $commentaries = Commentary::whereIn('fixture_id', $fixtureIds)
                    ->get()
                    ->toArray();
    
                Log::debug('STEP 4 - Found Commentaries:', $commentaries);
                
                $data['commentaries'] = $commentaries;
            }
    
            return $data;
        } catch (\Exception $e) {
            Log::error('Commentary addition error: '. $e->getMessage());
            return $data;
        }
    }
}