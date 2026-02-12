<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'inventory_code' => $this->inventory_code,
            'name' => $this->name,
            'type' => $this->type,
            'serial_number' => $this->serial_number,
            'specification' => $this->specification,
            'status' => $this->status,

            'member' => new MemberResource($this->whenLoaded('member')),

            'files' => $this->whenLoaded('files', function () {
                return $this->files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'file_name' => $file->file_name,
                        'url' => asset('storage/' . $file->file_path),
                    ];
                });
            }),

            'created_at' => $this->created_at,
        ];
    }
}
