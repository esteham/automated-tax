<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaxpayerRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'user_id'        => ['required','exists:users,id'],
            'tin_number'     => ['required','string','max:50','unique:taxpayers,tin_number'],
            'taxpayer_type'  => ['required','in:individual,business'],
            'business_name'  => ['nullable','string','max:255'],
            'business_type'  => ['nullable','string','max:255'],
            'nid'            => ['nullable','string','max:50'],
            'address'        => ['nullable','string'],
            'bank_details'   => ['nullable','array'],
        ];

    }
    
}
