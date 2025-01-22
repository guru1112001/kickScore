<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessCommentaryData;
use Illuminate\Support\Facades\Log;

class FetchCommentaries extends Command
{
    protected $signature = 'fetch:commentaries {--delay=5}';
    protected $description = 'Fetch and queue commentary data for processing';

    public function handle()
    {
        $baseUrl = 'https://api.sportmonks.com/v3/football/commentaries';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');
        $maxPages = 692; // Limit to 300 pages as per your requirements

        $this->info('Starting to fetch commentary data...');

        $page = 1;

        while ($page <= $maxPages) {
            $this->info("Fetching data for page $page...");

            $response = Http::get("$baseUrl?api_token={$apiToken}&filter=populate&page=$page");

            if ($response->failed()) {
                $this->error("Failed to fetch commentary data for page $page. HTTP Status: {$response->status()}");
                $this->error("Response: " . $response->body());
                Log::error('Response: ' . $response->body());
                return;
            }

            $data = $response->json('data') ?? [];
            if (empty($data)) {
                $this->info("No more commentary data found. Stopping.");
                break;
            }

            // Chunk data into smaller batches for queue processing
            $chunks = array_chunk($data, 500); // Adjust chunk size as needed
            foreach ($chunks as $chunk) {
                Queue::push(new ProcessCommentaryData($chunk));
                $this->info("Queued a chunk for page $page.");
                Log::info("Queued a chunk for page $page.");
                sleep($delay); // Delay to avoid API throttling
            }

            $page++;
        }

        $this->info("All commentary data has been fetched and queued for processing.");
        Log::info('All commentary data has been fetched and queued for processing.');
    }
}
