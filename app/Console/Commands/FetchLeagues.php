<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Models\LeagueTranslation;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchLeagues extends Command
{
    protected $signature = 'fetch:leagues';
    protected $description = 'Fetch football leagues from Sportmonks API';

    public function handle()
    {
        $client = new Client();
        $apiToken = config('services.sportmonks_api_token');
        $languages = ['en', 'de', 'es', 'it', 'ar', 'fr'];
        $urlBase = "https://api.sportmonks.com/v3/football/leagues";

        foreach ($languages as $locale) {
            $page = 1;
            $totalRecords = 0;

            do {
                $response = $client->get("{$urlBase}?api_token={$apiToken}&locale={$locale}&filters=populate&per_page=1000&page={$page}");
                $responseData = json_decode($response->getBody(), true);
                $leagues = $responseData['data'] ?? [];
                $page++;
                $totalRecords += count($leagues);

                foreach ($leagues as $leagueData) {
                    $league = League::updateOrCreate(
                        ['league_id' => $leagueData['id']], // Use league_id from API as the unique identifier
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

                    LeagueTranslation::updateOrCreate(
                        ['league_id' => $league->league_id, 'locale' => $locale],
                        ['name' => $leagueData['name']]
                    );
                }

            } while (count($leagues) === 1000);

            $this->info("Fetched and stored {$totalRecords} leagues for locale: {$locale}");
        }

        // Cache::tags('leagues')->flush(); // Clear cached leagues if any
        $this->info('All leagues fetched and stored successfully.');
    }
}
