<?php

namespace App\Http\Resources\Attachment;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
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
            'attachment_url' => $this->getFullUrl(),
            'file_name' => $this->file_name,
            'name' => $this->name
        ];
    }
}
