<?php

namespace App\Jobs;

use App\Models\City;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCityData implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $cityData;

    public function __construct(array $cityData)
    {
        $this->cityData = $cityData;
    }

    public function handle()
    {
        foreach ($this->cityData as $city) {
            City::updateOrCreate(
                ['id' => $city['id']],
                [
                    'country_id' => $city['country_id'],
                    'region' => $city['region'] ?? null,
                    'name' => $city['name'],
                    'latitude' => $city['latitude'] ?? null,
                    'longitude' => $city['longitude'] ?? null,
                    'geonameid' => $city['geonameid'] ?? null,
                ]
            );
        }

        Log::info('Processed ' . count($this->cityData) . ' cities.');
    }
}
