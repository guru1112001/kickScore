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
        return [
            'id' => $this->id,
            'sport_id' => $this->sport_id,
            'country_id' => $this->country_id,
            'name' => $this->name,
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
