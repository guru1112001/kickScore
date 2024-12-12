<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Player;
use App\Models\Statistic;
use App\Models\StatDetail;

class FetchPlayers extends Command
{
    protected $signature = 'fetch:players';
    protected $description = 'Fetch and store player data from API';

    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/football/players';
        $apiToken = config('services.sportmonks_api_token');
        $page = 1;

        $this->info('Starting to fetch player data...');

        do {
            $this->info("Fetching data for page $page...");
            $response = Http::get("$baseUrl?api_token={$apiToken}&page=$page&include=statistics.details");

            if ($response->failed()) {
                $this->error("Failed to fetch data for page $page. HTTP Status: {$response->status()}");
                $this->error("Response: " . $response->body());
                break;
            }

            $data = $response->json()['data'] ?? [];
            if (empty($data)) {
                $this->info("No data found on page $page. Ending fetch process.");
                break;
            }

            foreach ($data as $playerData) {
                $this->info("Processing player ID: {$playerData['id']} - {$playerData['common_name']}");

                $player = Player::updateOrCreate(
                    ['id' => $playerData['id']],
                    array_filter($playerData, fn($key) => $key !== 'statistics', ARRAY_FILTER_USE_KEY)
                );

                $this->info("Player stored/updated with ID: {$player->id}");

                foreach ($playerData['statistics'] as $statData) {
                    $stat = Statistic::updateOrCreate(
                        ['id' => $statData['id']],
                        [
                            'player_id' => $player->id,
                            'team_id' => $statData['team_id'],
                            'season_id' => $statData['season_id'],
                            'position_id' => $statData['position_id'],
                            'jersey_number' => $statData['jersey_number'],
                            'has_values' => $statData['has_values'],
                        ]
                    );

                    $this->info("  Statistic stored/updated with ID: {$stat->id}");

                    foreach ($statData['details'] as $detail) {
                        StatDetail::updateOrCreate(
                            ['id' => $detail['id']],
                            [
                                'player_statistic_id' => $stat->id,
                                'type_id' => $detail['type_id'],
                                'value' => $detail['value'],
                            ]
                        );

                        $this->info("    StatDetail stored/updated with ID: {$detail['id']}");
                    }
                }
            }

            $this->info("Finished processing page $page.");
            $page++;
        } while (count($data) > 0);

        $this->info('Data fetch completed!');
    }
}
