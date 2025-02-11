<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessFixtureData;

class FetchFixtures extends Command
{
    protected $signature = 'fetch:fixtures {--delay=5}';
    protected $description = 'Fetch and queue unique fixture data for processing';

    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/football/fixtures/multi/';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');

        $this->info('Starting to fetch fixture data...');

        // Step 1: Get unique fixture IDs from the commentary table
        $uniqueFixtureIds = DB::table('commentaries')
            ->select('fixture_id')
            ->distinct()
            ->pluck('fixture_id')
            ->toArray();

        if (empty($uniqueFixtureIds)) {
            $this->info('No unique fixture IDs found in the commentary table.');
            return;
        }

        // Step 2: Process fixture IDs in batches of 50
        $chunks = array_chunk($uniqueFixtureIds, 50);

        foreach ($chunks as $chunk) {
            $idString = implode(',', $chunk); // Join 50 IDs into a comma-separated string
            $this->info("Fetching data for fixtures: $idString");

            // Construct the correct API URL
            $apiUrl = "{$baseUrl}{$idString}?api_token={$apiToken}&include=participants";

            // Fetch the fixtures from the API
            $response = Http::get($apiUrl);

            \Log::info("API Request: $apiUrl");

            if ($response->failed()) {
                $this->error("Failed to fetch fixture data for IDs: $idString. HTTP Status: {$response->status()}");
                $this->error("Response: " . $response->body());
                return;
            }

            $data = $response->json('data') ?? [];
            \Log::info($data);

            if (empty($data)) {
                $this->info("No fixture data found for IDs: $idString.");
                continue;
            }

            // Step 3: Queue the data for processing
            $chunks = array_chunk($data, 50);
            foreach ($chunks as $chunk) {
                Queue::push(new ProcessFixtureData($chunk));
                $this->info("Queued a chunk of fixture data for IDs: $idString.");
                sleep($delay); // Delay to avoid API throttling
            }
        }

        $this->info("All fixture data has been fetched and queued for processing.");
    }
}
