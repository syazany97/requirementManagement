<?php

namespace App\Http\Resources\Requirement;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RequirementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->getModelName($this->getTable()),
            'description' => $this->description,
            'priority_id' => $this->requirement_priority_id,
            'priority' => $this->whenLoaded('priority'),
            'name' => $this->name,
            'module_id' => $this->module_id,
            'numbering' => $this->numbering,
            'assigned_id' => $this->assigned_id,
            'assigned' => $this->whenLoaded('assigned'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
