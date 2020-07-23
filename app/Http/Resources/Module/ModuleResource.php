<?php

namespace App\Http\Resources\Module;

use App\Http\Resources\Requirement\RequirementResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'type' => Str::singular($this->getTable()),
            'name' => $this->name,
            'numbering' => $this->numbering,
            'children' => self::collection($this->whenLoaded('children')),
            'requirements' => RequirementResource::collection($this->whenLoaded('requirements')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
