<?php

namespace App\Http\Resources\Contact;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = $this->resource->only(
            [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'opportunity',
                'tags',
                'listContacts',
            ]
        );

        $result['user']['first_name'] = optional($this->resource->user)->first_name;
        $result['user']['avatar'] = optional($this->resource->user)->avatar ? FileService::url(optional($this->resource->user)->avatar) : null;

        return $result;
    }
}
