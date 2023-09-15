<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $this->route('user')],
            'number' => ['required', 'numeric', 'unique:users,number,' . $this->route('user'), 'digits:10', 'regex:/^[6-9]\d{9}$/'],
            'role' => ['required', 'in:' . implode(',', ROLES)],
            'gender' => ['required', 'in:' . implode(',', GENDERS)],
            // Basic Details
            'date_of_birth' => ['sometimes', 'nullable', 'date'],
            'pan_card_number' => ['sometimes', 'nullable', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'aadhar_card_number' => ['sometimes', 'nullable', 'numeric', 'digits:12'],
            'occupation_type' => ['sometimes', 'nullable', 'string'],
            'organization_name' => ['sometimes', 'nullable', 'string'],
            'monthly_income' => ['sometimes', 'nullable', 'numeric'],
            'area' => ['sometimes', 'nullable', 'string'],
            'landmark' => ['sometimes', 'nullable', 'string'],
            'city' => ['sometimes', 'nullable', 'string'],
            'district' => ['sometimes', 'nullable', 'string'],
            'state' => ['sometimes', 'nullable', 'string'],
            'pincode' => ['sometimes', 'nullable', 'numeric', 'digits:6'],
        ];
    }
}