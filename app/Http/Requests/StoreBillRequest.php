<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bill_reference' => ['required', 'max:255'],
            'bill_date' => ['required', 'date'],
            'bill_stage_id' => [
                'required', 
                'numeric', 
                'exists:bill_stages,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'bill_stage_id.required' => 'The bill stage field is required.',
            'bill_stage_id.numeric' => 'The bill stage field must be a number.',
            'bill_stage_id.exists' => 'The selected bill stage is invalid.',
        ];
    }
}
