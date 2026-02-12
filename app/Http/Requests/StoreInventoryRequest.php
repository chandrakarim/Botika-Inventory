<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
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
            'inventory_code' => 'required|unique:inventories',
            'name' => 'required|string',
            'type' => 'required|string',
            'serial_number' => 'nullable|string',
            'specification' => 'nullable|string',
            'status' => 'required|string|in:baik,rusak,dilelang,tidak_dipakai',
            'member_id' => 'nullable|exists:members,id',
            'files'   => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',

        ];
    }
    protected function prepareForValidation()
    {
        if ($this->hasFile('files')) {
            $this->merge([
                'files' => $this->file('files')
            ]);
        }
    }
}
