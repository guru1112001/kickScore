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
            // Find past fixture IDs where any of these participants played
            $fixtureIds = Fixture::whereJsonContains('participants', fn($query) => 
                $query->whereIn('id', $this->participantIds)
            )->pluck('id')->toArray();

            if (!empty($fixtureIds)) {
                // Fetch commentaries for the matched fixtures
                $commentaries = Commentary::whereIn('fixture_id', $fixtureIds)->get()->toArray(); // Fetches all columns


                // Store commentaries in the live fixture
                LiveFixture::where('fixture_id', $this->fixtureId)->update([
                    'commentaries' => json_encode($commentaries),
                ]);

                Log::info("Updated commentaries for fixture: {$this->fixtureId}");
            }
        } catch (\Exception $e) {
            Log::error("Error updating commentaries for fixture {$this->fixtureId}: " . $e->getMessage());
        }
    }
}
