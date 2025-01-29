<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\LiveFixture;
use Carbon\Carbon;

class UpdateLiveFixtures extends Command
{
    protected $signature = 'fixtures:update-live';
    protected $description = 'Update live fixtures every 10 minutes from match start time';

    public function handle()
    {
        $now = now();
        $tenMinutesAgo = $now->copy()->subMinutes(10);

        // Get fixtures that started in the last 10 minutes or are ongoing
        $activeFixtures = LiveFixture::where(function($query) use ($now, $tenMinutesAgo) {
                $query->where('starting_at', '>=', $tenMinutesAgo)
                      ->where('starting_at', '<=', $now);
            })
            ->orWhere(function($query) use ($now) {
                $query->where('starting_at', '<=', $now)
                      ->whereRaw('DATE_ADD(starting_at, INTERVAL length MINUTE) >= ?', [$now]);
            })
            ->get();

        $apiUrl = 'https://api.sportmonks.com/v3/football/fixtures';
        $apiKey = config('services.sportmonks_api_token');
        $includes = 'sport:name;participants.players.position:name;formations;lineups;weatherReport;venue;timeline;trends;league:name;metadata;comments;events.type:name;events.subtype';

        foreach ($activeFixtures as $fixture) {
            try {
                $response = Http::get("$apiUrl/{$fixture->fixture_id}", [
                    'api_token' => $apiKey,
                    'include' => $includes,
                    'timezone' => 'Asia/Kolkata',
                ]);

                if ($response->successful()) {
                    $data = $response->json()['data'] ?? [];
                    
                    // Update match end time if length changes
                    $fixture->update([
                       'sport_id' => $data['sport_id'] ?? $fixture->sport_id,
                        'league_id' => $data['league_id'] ?? $fixture->league_id,
                        'season_id' => $data['season_id'] ?? $fixture->season_id,
                        'name' => $data['name'] ?? $fixture->name,
                        'starting_at' => $data['starting_at'] ?? $fixture->starting_at,
                        'length' => $data['length'] ?? $fixture->length,
                        'details' => $data['details'] ?? $fixture->details,
                        'participants' => $data['participants'] ?? $fixture->participants,
                        'weather_report' => $data['weatherreport'] ?? $fixture->weather_report,
                        'venue' => $data['venue'] ?? $fixture->venue,
                        'formations' => $data['formations'] ?? $fixture->formations,
                        'metadata' => $data['metadata'] ?? $fixture->metadata,
                        'lineups' => $data['lineups'] ?? $fixture->lineups,
                        'timeline' => $data['timeline'] ?? $fixture->timeline,
                        'trends' => $data['trends'] ?? $fixture->trends,
                        'events' => $data['events'] ?? $fixture->events,
                        'comments' => $data['comments'] ?? $fixture->comments,
                    ]);

                    $this->info("Updated fixture: {$fixture->name} at " . now()->format('H:i:s'));
                }
            } catch (\Exception $e) {
                $this->error("Error updating {$fixture->name}: " . $e->getMessage());
            }
        }
    }
}