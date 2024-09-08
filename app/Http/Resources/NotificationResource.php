<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->data;
         return [
            'id'=>$this->id,
            'title' => $data['title'],
            'status'=>$data['status'],
            'body' => $data['body'] ?? null,
            'url'=>$data['url']??null,
            'read_at'=>$this->read_at,
            'created_at'=>$this->created_at,
            
        ];
    }
}
