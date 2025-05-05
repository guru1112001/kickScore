<?php

namespace App\Jobs;

use App\Models\Fixture;
use App\Models\Commentary;
use App\Models\LiveFixture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCommentariesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fixtureId;
    protected $participantIds;

    public function __construct($fixtureId, $participantIds)
    {
        $this->fixtureId = $fixtureId;
        $this->participantIds = $participantIds;
    }

    public function handle()
    {
        try {
            // Limit the number of fixture IDs fetched
            $fixtureIds = Fixture::where(function ($query) {
                foreach ($this->participantIds as $participantId) {
                    $query->orWhereJsonContains('participants', ['id' => $participantId]);
                }
            })
            ->limit(100) // Set a reasonable limit
            ->pluck('id')
            ->toArray();
    
            if (!empty($fixtureIds)) {
                $commentaries = [];
    
                // Fetch commentaries in chunks to avoid memory overload
                Commentary::whereIn('fixture_id', $fixtureIds)
                    ->chunk(500, function ($batch) use (&$commentaries) {
                        foreach ($batch as $commentary) {
                            $commentaries[] = $commentary->toArray();
                        }
                    });
    
                // Store only a limited number of commentaries to prevent large JSON size
                LiveFixture::where('fixture_id', $this->fixtureId)->update([
                    'commentaries' => json_encode(array_slice($commentaries, 0, 1000), JSON_PRETTY_PRINT),
                ]);
    
                Log::info("Updated commentaries for fixture: {$this->fixtureId}");
            }
        } catch (\Exception $e) {
            Log::error("Error updating commentaries for fixture {$this->fixtureId}: " . $e->getMessage());
        }
    }
    
}
