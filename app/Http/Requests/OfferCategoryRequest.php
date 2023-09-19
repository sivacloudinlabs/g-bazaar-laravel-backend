<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:offer_categories,name,' . $this->route('offer_category')],
            'category_image' => ['sometimes', 'nullable', 'url'],
            'selected_category_image' => ['sometimes', 'nullable', 'url'],
        ];
    }
}