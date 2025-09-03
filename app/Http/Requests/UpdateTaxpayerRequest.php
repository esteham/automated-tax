<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaxpayerRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'tin_number'     => ['required','string','max:50', Rule::unique('taxpayers','tin_number')->ignore($this->taxpayer->id)],
            'taxpayer_type'  => ['required','in:individual,business'],
            'business_name'  => ['nullable','string','max:255'],
            'business_type'  => ['nullable','string','max:255'],
            'nid'            => ['nullable','string','max:50'],
            'address'        => ['nullable','string'],
            'bank_details'   => ['nullable','array'],
        ];

    }
    
}
