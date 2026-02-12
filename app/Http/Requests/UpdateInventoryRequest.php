<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'inventory_code' => 'sometimes|string|max:255',
            'name'           => 'sometimes|string|max:255',
            'type'           => 'sometimes|string|max:255',
            'serial_number'  => 'sometimes|string|max:255',
            'specification'  => 'sometimes|string|max:1000',
            'status' => 'sometimes|string|in:baik,rusak,dilelang,tidak_dipakai',
            'member_id'      => 'nullable|exists:members,id',
            'files.*'        => 'sometimes|file|max:10240', // maksimal 10MB per file
        ];
    }
}
