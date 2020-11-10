<?php

namespace App\Http\Resources\Log;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $modal = $this->getClassBaseName($this->subject_type);

        return [
            'causer' => $this->causer,
            'description' => $this->description === 'created' ?
                sprintf('created this %s', $modal) :
                $this->formatUpdatedInformation($modal, $this->properties['attributes']),
            'properties' => $this->properties,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    private function formatUpdatedInformation(string $modal, $attributes)
    {
        return sprintf("Updated %s's %s", $modal, collect($attributes)->keys()->implode(', '));
    }

    private function getClassBaseName(string $subjectType)
    {
        return str_replace('_', ' ', Str::title(Str::snake(class_basename($subjectType))));
    }
}
