<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = $request->input('locale', 'en');
        // $locale = $request->input('locale', 'en');
        
        // Fetch the translation for the specified locale or fallback to the default name
        $translatedName = $this->translations
        ->where('locale', $locale)
        ->first()?->name ?? $this->name;
        return [
            'id' => $this->id,
            'league_id'=>$this->league_id,
            'sport_id' => $this->sport_id,
            'country_id' => $this->country_id,
            'name' => $translatedName,
            'active' => $this->active,
            'short_code' => $this->short_code,
            'image_path' => $this->image_path,
            'type' => $this->type,
            'sub_type' => $this->sub_type,
            'last_played_at' => $this->last_played_at,
            'category' => $this->category,
        ];
    }
    
}
