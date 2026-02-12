<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'name' => $this->name,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'position'   => new PositionResource($this->whenLoaded('position')),
            'created_at' => $this->created_at,
        ];
    }
}
