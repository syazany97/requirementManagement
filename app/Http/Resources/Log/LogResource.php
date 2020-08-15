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
            'user' => optional(User::find($this->causer_id))->name,
            'description' => $this->description === 'created' ? sprintf('Created this %s', $modal) : $this->formatUpdatedInformation($modal, $this->properties->toArray()),
//            'updated' => $this->properties
        ];
    }

    private function formatUpdatedInformation(string $modal, $attributes)
    {
        // convert attributes of array to string
        $newAttributes = collect(Arr::get($attributes, 'attributes', []));
        $oldAttributes = collect(Arr::get($attributes, 'old', []));

        if (!empty($newAttributes)) {
            return 'Updated this ' . $modal . ' ' . $newAttributes->map(function ($item, $key) use ($oldAttributes) {
                    $oldAttribute = $oldAttributes->first(function ($oldValue, $oldKey) use ($key) {
                        return $oldKey === $key;
                    });

                    return
                        sprintf('%s from %s to %s', $key ,$item, $oldAttribute)
                    ;
                })->implode(' ');
        }

        return "";

    }

    private function getClassBaseName(string $subjectType)
    {
        return str_replace('_', ' ', Str::title(Str::snake(class_basename($subjectType))));
    }
}
