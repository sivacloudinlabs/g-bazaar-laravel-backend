<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'offer_id' => ['required', 'exists:offers,id,is_active,1'],
            'requested_amount' => ['required'],
            'loan_term' => ['required'],
            'quoted_amount' => ['required'],
            'others' => ['required'],
            // personal information
            'personal_information' => ['sometimes', 'nullable', 'array'],
            'personal_information.name' => ['required_with:personal_information', 'string'],
            'personal_information.number' => ['required_with:personal_information', 'numeric', 'digits:10', 'regex:/^[6-9]\d{9}$/'],
            'personal_information.email' => ['required_with:personal_information', 'email'],
            'personal_information.date_of_birth' => ['required_with:personal_information', 'date', 'before:18 years ago'],
            'personal_information.gender' => ['required_with:personal_information', 'in:' . implode(',', GENDERS)],
            'personal_information.pan_number' => ['required_with:personal_information', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'personal_information.aadhar_number' => ['required_with:personal_information', 'numeric', 'digits:12'],

            // Communication address
            'communication_address' => ['sometimes', 'nullable', 'array'],
            'communication_address.address_line' => ['required_with:communication_address', 'string'],
            'communication_address.locality' => ['required_with:communication_address', 'string'],
            'communication_address.city' => ['required_with:communication_address', 'string'],
            'communication_address.landmark' => ['required_with:communication_address', 'string'],
            'communication_address.state' => ['required_with:communication_address', 'string'],
            'communication_address.pincode' => ['required_with:communication_address', 'string', 'digits:6'],
            'communication_address.house_status' => ['required_with:communication_address', 'string', 'in:'. implode(',', HOME_STATUS)],

            // Permanent address
            'permanent_address' => ['sometimes', 'nullable', 'array'],
            'permanent_address.address_line' => ['required_with:permanent_address', 'string'],
            'permanent_address.locality' => ['required_with:permanent_address', 'string'],
            'permanent_address.city' => ['required_with:permanent_address', 'string'],
            'permanent_address.landmark' => ['required_with:permanent_address', 'string'],
            'permanent_address.state' => ['required_with:permanent_address', 'string'],
            'permanent_address.pincode' => ['required_with:permanent_address', 'string', 'digits:6'],

            // Work Information
            'work_information' => ['sometimes', 'nullable', 'array'],
            'work_information.work_type' => ['required_with:work_information', 'string'],
            'work_information.organization_type' => ['required_with:work_information', 'string'],
            'work_information.organization_sector' => ['required_with:work_information', 'string'],
            'work_information.organization_name' => ['required_with:work_information', 'string'],
            'work_information.income' => ['required_with:work_information', 'numeric'],
            'work_information.joining_date' => ['required_with:work_information', 'date'],
            'work_information.employee_id' => ['required_with:work_information'],
            'work_information.designation' => ['required_with:work_information', 'string'],
            'work_information.year_of_experience' => ['required_with:work_information', 'numeric'],

            // Upload Document
            'upload_document' => ['sometimes', 'nullable', 'array'],
            'upload_document.profile_picture' => ['required_with:upload_document', 'url'],
            'upload_document.pan_card' => ['required_with:upload_document', 'url'],
            'upload_document.aadhar_card' => ['required_with:upload_document', 'url'],
            'upload_document.form16' => ['sometimes', 'nullable', 'url'],
            'upload_document.payslip' => ['sometimes', 'nullable', 'url'],
            'upload_document.bank_statement' => ['required_with:upload_document', 'url'],
            'upload_document.offer_letter' => ['sometimes', 'nullable', 'url'],
            'upload_document.itr' => ['sometimes', 'nullable', 'url'],
            'upload_document.comapany_id_card' => ['sometimes', 'nullable', 'url'],

            'status' => ['required'],
            'digital_signature' => ['required', 'url'],
        ];
    }
}