<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow any authenticated user to submit TIN request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'nid_number' => [
                'required',
                'string',
                'max:50',
                'unique:tin_requests,nid_number,NULL,id,deleted_at,NULL'
            ],
            'date_of_birth' => 'required|date|before:today',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'present_address' => 'required|string|max:1000',
            'permanent_address' => 'required|string|max:1000',
            'occupation' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:1000',
            'purpose' => 'required|string|max:1000',
        ];
    }
}
