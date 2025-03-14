<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessTypeData;

class FetchTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:types {--delay=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and queue type data for processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/core/types';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');
        $page = 1;

        $this->info('Starting to fetch types data...');

        do {
            $this->info("Fetching data for page $page...");

            $response = Http::get("$baseUrl?api_token={$apiToken}&filter=populate&page=$page");

            if ($response->failed()) {
                $this->error("Failed to fetch data for page $page. HTTP Status: {$response->status()}");
                $this->error("Response: " . $response->body());
                break;
            }

            $data = $response->json('data') ?? [];
            if (empty($data)) {
                $this->info("No more data found on page $page. Stopping fetch.");
                break;
            }

            // Divide data into smaller chunks for processing
            $chunks = array_chunk($data, 500);

            foreach ($chunks as $index => $chunk) {
                Queue::push(new ProcessTypeData($chunk));
                $this->info("Queued chunk " . ($index + 1) . " from page $page for processing.");
                sleep($delay); // Add delay to reduce server load
            }

            $this->info("Finished processing page $page.");
            $page++; // Increment to fetch the next page
        } while (!empty($data)); // Continue until no data is returned

        $this->info("All types data has been fetched and queued for processing.");
    }
}
