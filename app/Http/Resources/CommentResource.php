<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'details' => $this->details,
            'user' => $this->whenLoaded('user'),
            'meta' => [
                'permissions' => [
                    'delete' => auth()->user()->id === $this->user_id,
                    'update' => auth()->user()->id === $this->user_id
                ]
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
