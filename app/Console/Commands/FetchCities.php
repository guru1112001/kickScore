<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessCityData;

class FetchCities extends Command
{
    protected $signature = 'fetch:cities {--delay=5}';
    protected $description = 'Fetch and queue city data for processing';

    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/core/cities';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');

        $this->info('Starting to fetch city data...');

        $page = 1;

        while (true) {
            $this->info("Fetching data for page $page...");

            $response = Http::get("$baseUrl?api_token={$apiToken}&filter=populate&page=$page");

            if ($response->failed()) {
                $this->error("Failed to fetch city data for page $page. HTTP Status: {$response->status()}");
                $this->error("Response: " . $response->body());
                return;
            }

            $data = $response->json('data') ?? [];
            if (empty($data)) {
                $this->info("No more city data found. Stopping.");
                break;
            }

            $chunks = array_chunk($data, 500); // Process 50 cities per batch
            foreach ($chunks as $chunk) {
                Queue::push(new ProcessCityData($chunk));
                $this->info("Queued a chunk for page $page.");
                sleep($delay); // Delay to avoid API throttling
            }

            $page++;
        }

        $this->info("All city data has been fetched and queued for processing.");
    }
}
