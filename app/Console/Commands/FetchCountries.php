<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessCountryData;

class FetchCountries extends Command
{
    protected $signature = 'fetch:countries {--delay=2}';
    protected $description = 'Fetch and queue country data for processing';

    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/core/countries';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');
        $page = 1;

        $this->info('Starting to fetch countries data...');

        do {
            $this->info("Fetching data for page $page...");
            $response = Http::get("$baseUrl?api_token={$apiToken}&filter=populate&page=$page");

            if ($response->failed()) {
                $this->error("Failed to fetch data for page $page. HTTP Status: {$response->status()}");
                $this->error("Response: ");
                return;
            }

            $data = $response->json('data') ?? [];
            if (empty($data)) {
                $this->info("No more data found. Ending fetch.");
                break;
            }

            $chunks = array_chunk($data, 50); // Split data into chunks of 50

            foreach ($chunks as $index => $chunk) {
                Queue::push(new ProcessCountryData($chunk));
                $this->info("Queued chunk " . ($index + 1) . " for processing.");
                sleep($delay); // Add delay to avoid overloading server
            }

            $page++;
        } while (!empty($data));

        $this->info("All countries data has been fetched and queued for processing.");
    }
}
