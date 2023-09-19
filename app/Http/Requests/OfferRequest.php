<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'offer_type_id' => ['required', 'exists:offer_types,id,is_active,1'],
            'offer_category_id' => ['required', 'exists:offer_categories,id,is_active,1'],
            'bank_id' => ['required', 'exists:banks,id,is_active,1'],
            'starting_date' => ['required', 'date', 'after_or_equal:now'],
            'ending_date' => ['required', 'date', 'after:starting_date'],
            'min_cibil' => ['required', 'numeric', 'min_digits:2', 'min_digits:3'],
            'max_cibil' => ['required', 'numeric', 'gt:min_cibil', 'min_digits:2', 'min_digits:3'],
            'offer_title' => ['required', 'string'],
            'secondary_title' => ['required', 'string'],
            'offer_banner' => ['required', 'url'],
            'offer_description' => ['required',],
            'offer_terms' => ['required',],
            'feature_list' => ['required', 'array']
        ];
    }
}