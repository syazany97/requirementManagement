<?php

namespace App\Http\Resources\TestCase;

use App\Http\Resources\Requirement\RequirementResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TestCaseResource extends JsonResource
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
            'requirement_id' => $this->requirement_id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'preconditions' => $this->preconditions,
            'user' => new UserResource($this->whenLoaded('user')),
            'relationships' => [
                'steps' => TestCaseStepsResource::collection($this->whenLoaded('steps')),
                'requirement' => new RequirementResource($this->whenLoaded('requirement'))
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
