<?php

namespace App\Jobs;

use App\Models\Commentary;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCommentaryData implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $commentaryData;

    public function __construct(array $commentaryData)
    {
        $this->commentaryData = $commentaryData;
    }

    public function handle()
    {
        foreach ($this->commentaryData as $commentary) {
            Commentary::updateOrCreate(
                ['id' => $commentary['id']],
                [
                    'fixture_id' => $commentary['fixture_id'],
                    'comment' => $commentary['comment'],
                    'minute' => $commentary['minute'],
                    'extra_minute' => $commentary['extra_minute'],
                    'is_goal' => $commentary['is_goal'],
                    'is_important' => $commentary['is_important'],
                    'order' => $commentary['order'],
                ]
            );
        }

        Log::info('Processed ' . count($this->commentaryData) . ' commentaries.');
    }
}
