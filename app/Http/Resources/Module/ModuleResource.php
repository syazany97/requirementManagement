<?php

namespace App\Http\Resources\Module;

use App\Http\Resources\Requirement\RequirementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'title' => $this->title,
            'requirements' => RequirementResource::collection($this->whenLoaded('requirements'))
        ];
    }
}