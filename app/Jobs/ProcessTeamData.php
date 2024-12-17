<?php

namespace App\Jobs;

use App\Models\Sportmonkteam;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTeamData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $chunk;
    /**
     * Create a new job instance.
     */
    public function __construct(array $chunk)
    {
        $this->chunk=$chunk;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->chunk as $team) {
            Sportmonkteam::updateOrCreate(
                ['id' => $team['id']],
                [
                    'sport_id' => $team['sport_id'] ?? null,
                    'country_id' => $team['country_id'] ?? null,
                    'venue_id' => $team['venue_id'] ?? null,
                    'gender' => $team['gender'] ?? null,
                    'name' => $team['name'] ?? null,
                    'short_code' => $team['short_code'] ?? null,
                    'image_path' => $team['image_path'] ?? null,
                    'founded' => $team['founded'] ?? null,
                    'type' => $team['type'] ?? null,
                    'placeholder' => $team['placeholder'] ?? null,
                    'last_played_at' => $team['last_played_at'] ?? null,
                ]
            );
        }
    
    }
}
