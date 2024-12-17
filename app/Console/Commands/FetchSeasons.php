<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessSeasonData;

class FetchSeasons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:seasons {--delay=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and queue season data for processing';

    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/football/seasons';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');
        $page = 1;

        $this->info('Starting to fetch seasons data...');

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

            $chunks = array_chunk($data, 50); // Divide data into chunks of 50 for batch processing.

            foreach ($chunks as $index => $chunk) {
                Queue::push(new ProcessSeasonData($chunk));
                $this->info("Queued chunk " . ($index + 1) . " from page $page for processing.");
                sleep($delay); // Add delay to prevent server overload.
            }

            $page++;
        } while (true);

        $this->info('All seasons data has been fetched and queued for processing.');
    }
}
