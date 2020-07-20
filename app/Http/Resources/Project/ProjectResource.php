<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Module\ModuleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status_id,
            'description' => $this->description,
            'owner' => $this->whenLoaded('user'),
            'modules_count' => $this->modules_count,
            'modules' =>  ModuleResource::collection($this->whenLoaded('modules')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
