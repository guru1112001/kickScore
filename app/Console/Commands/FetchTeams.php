<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTeamData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

class FetchTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:teams {--delay=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and queue team data for processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl='https://api.sportmonks.com/v3/football/teams';
        $apiToken = config('services.sportmonks_api_token');
        $delay = (int) $this->option('delay');
        $page = 1;
        $this->info('Starting to fetch teams data...');
        do{
            $this->info("Fetching data for page $page...");
            $response = Http::get("$baseUrl?api_token={$apiToken}&filter=populate&page=$page");
            if($response->failed()){
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
         $chunks = array_chunk($data, 50);

         foreach ($chunks as $index => $chunk) {
             Queue::push(new ProcessTeamData($chunk));
             $this->info("Queued chunk " . ($index + 1) . " from page $page for processing.");
             sleep($delay); // Add delay to reduce server load
         }

         $this->info("Finished processing page $page.");
         $page++; // Increment to fetch the next page
     } while (!empty($data)); // Continue until no data is returned

     $this->info("All teams data has been fetched and queued for processing.");
 }
}
