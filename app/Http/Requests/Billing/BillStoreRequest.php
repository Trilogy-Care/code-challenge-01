<?php

namespace App\Http\Requests\Billing;

use App\Models\Bill;
use App\Models\BillStage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->can('create', Bill::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bill_reference' => ['required', 'string', 'max:255'],
            'bill_date' => ['required', 'string', 'max:19', 'date_format:Y-m-d H:i:s'],
            'submitted_at' => ['sometimes', 'string', 'max:19', 'date_format:Y-m-d H:i:s'],
            'approved_at' => ['sometimes', 'string', 'max:19', 'date_format:Y-m-d H:i:s'],
            'on_hold_at' => ['sometimes', 'string', 'max:19', 'date_format:Y-m-d H:i:s'],
            'bill_stage_id' => ['required', 'integer', Rule::exists(BillStage::make()->getTable(), 'id')],
        ];
    }
}
