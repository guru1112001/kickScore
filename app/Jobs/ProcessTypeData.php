<?php

namespace App\Jobs;

use App\Models\Type;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTypeData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunk;

    /**
     * Create a new job instance.
     */
    public function __construct(array $chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->chunk as $type) {
            Type::updateOrCreate(
                ['id' => $type['id']],
                [
                    'name' => $type['name'],
                    'code' => $type['code'] ?? null,
                    'developer_name' => $type['developer_name'] ?? null,
                    'stat_group' => $type['stat_group'] ?? null,
                    'model_type' => $type['model_type'] ?? null,
                ]
            );
        }
    }
}
