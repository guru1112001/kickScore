<?php

namespace App\Console\Commands;

use App\Models\League;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchLeagues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:leagues';
    protected $description = 'Fetch football leagues from Sportmonks API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $apiToken = config('app.sportmonks_api_token');
        $url = "https://api.sportmonks.com/v3/football/leagues?api_token={$apiToken}";

        $response = $client->get($url);
        $leagues = json_decode($response->getBody(), true)['data'];

        foreach ($leagues as $leagueData) {
            League::updateOrCreate(
                ['id' => $leagueData['id']],
                [
                    'sport_id' => $leagueData['sport_id'],
                    'country_id' => $leagueData['country_id'],
                    'name' => $leagueData['name'],
                    'active' => $leagueData['active'],
                    'short_code' => $leagueData['short_code'] ?? null,
                    'image_path' => $leagueData['image_path'],
                    'type' => $leagueData['type'],
                    'sub_type' => $leagueData['sub_type'] ?? null,
                    'last_played_at' => $leagueData['last_played_at'] ?? null,
                    'category' => $leagueData['category'],
                ]
            );
        }
        Cache::forget('leagues_all');
        Cache::forget('leagues_live');
        // Clear specific caches as needed
        Cache::tags('leagues')->flush();  // If you use cache tags
        $this->info('Leagues fetched and stored successfully.');
    
    }
}
