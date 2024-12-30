<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\SportmonkCountry;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessCountryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $countries;

    public function __construct(array $countries)
    {
        $this->countries = $countries;
    }

    public function handle()
    {
        foreach ($this->countries as $countryData) {
            SportmonkCountry::updateOrCreate(
                ['id' => $countryData['id']],
                [
                    'continent_id' => $countryData['continent_id'] ?? null,
                    'name' => $countryData['name'] ?? null,
                    'official_name' => $countryData['official_name'] ?? null,
                    'fifa_name' => $countryData['fifa_name'] ?? null,
                    'iso2' => $countryData['iso2'] ?? null,
                    'iso3' => $countryData['iso3'] ?? null,
                    'latitude' => $countryData['latitude'] ?? null,
                    'longitude' => $countryData['longitude'] ?? null,
                    'geonameid' => $countryData['geonameid'] ?? null,
                    'border' => $countryData['border'] ?? null,
                    'image_path' => $countryData['image_path'] ?? null,
                ]
            );
        }
    }
}
