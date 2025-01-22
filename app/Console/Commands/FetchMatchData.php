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
        $targetTime = Carbon::now()->addMinutes(45);

        // Find matches starting in 45 minutes
        $matches = LiveFixture::whereDate('starting_at', Carbon::today())
        ->where('starting_at', '=', $targetTime->format('Y-m-d H:i:00'))
        ->get();

        if ($matches->isEmpty()) {
            $this->info('No matches found to fetch data for.');
            return;
        }

        $apiUrl = 'https://api.sportmonks.com/v3/football/fixtures';
        $apiKey = config('services.sportmonks_api_token');
        $includes = 'sport:name;participants.players.position:name;formations;lineups;weatherReport;venue;timeline;trends;league:name;metadata;comments';

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
                $match->update(['details' => json_encode($data)]);
            } else {
                $this->error("Failed to fetch data for match: {$match->name}");
            }
        }
    }
}
