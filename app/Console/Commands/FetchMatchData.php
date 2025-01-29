<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\LiveFixture;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
// use App\Models\Match; // Replace with your actual model

class FetchMatchData extends Command
{
    protected $signature = 'fetch:match-data';
    protected $description = 'Fetch match data from API 45 minutes before starting_at';

    public function handle()
    {
        $targetTime = Carbon::now();

        // Find matches starting 45 minutes from now
        $matches = LiveFixture::whereDate('starting_at', Carbon::today())
            ->whereBetween('starting_at', [
                $targetTime->addMinutes(45)->startOfMinute(),
                $targetTime->addMinutes(45)->endOfMinute()
            ])
            ->get();

        if ($matches->isEmpty()) {
            $this->info('No matches found to fetch data for.');
            return;
        }

        $apiUrl = 'https://api.sportmonks.com/v3/football/fixtures';
        $apiKey = config('services.sportmonks_api_token');
        $includes = 'sport:name;participants.players.position:name;formations;lineups;weatherReport;venue;timeline;trends;league:name;metadata;comments;events.type:name;events.subtype';

        foreach ($matches as $match) {
            // Fetch match data from API
            $response = Http::get("$apiUrl/{$match->fixture_id}", [
                'api_token' => $apiKey,
                'include' => $includes,
                'timezone' => 'Asia/Kolkata',
            ]);

            if ($response->successful()) {
                $this->info("Data fetched for match: {$match->name}");
                // Process the response as needed
                $data = $response->json();
                // Example: Store data or update the match record
                $match->update([
                    // 'details' => json_encode($data),
                   'sport_id' => $data['data']['sport_id'] ?? $match->sport_id,
                    'league_id' => $data['data']['league_id'] ?? $match->league_id,
                    'season_id' => $data['data']['season_id'] ?? $match->season_id,
                    'name' => $data['data']['name'] ?? $match->name,
                    'starting_at' => $data['data']['starting_at'] ?? $match->starting_at,
                    'length' => $data['data']['length'] ?? $match->length,
                    'details' => $data['data']['details'] ?? $match->details,
                    'participants' => $data['data']['participants'] ?? $match->participants,
                    'weather_report' => $data['data']['weatherreport'] ?? $match->weather_report,
                    'venue' => $data['data']['venue'] ?? $match->venue,
                    'formations' => $data['data']['formations'] ?? $match->formations,
                    'metadata' => $data['data']['metadata'] ?? $match->metadata,
                    'lineups' => $data['data']['lineups'] ?? $match->lineups,
                    'timeline' => $data['data']['timeline'] ?? $match->timeline,
                    'trends' => $data['data']['trends'] ?? $match->trends,
                    'events' => $data['data']['events'] ?? $match->events,
                    'comments' => $data['data']['comments'] ?? $match->comments,

            ]);
            } else {
                $this->error("Failed to fetch data for match: {$match->name}");
            }
        }
    }
}
