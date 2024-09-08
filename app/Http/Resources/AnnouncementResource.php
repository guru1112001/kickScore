<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'Id'=>$this->id,
            'Title'=>$this->title,
            'Description'=>$this->description,
            'Image'=>$this->image ? asset('storage/' . $this->image) : null,
            'Schedule_at'=>$this->schedule_at,
        ];
    }
}
