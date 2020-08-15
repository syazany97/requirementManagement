<?php

namespace App\Http\Resources\Log;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
          'user' => User::find($this->causer_id)->name,
          'updated' => $this->properties
        ];
    }
}
