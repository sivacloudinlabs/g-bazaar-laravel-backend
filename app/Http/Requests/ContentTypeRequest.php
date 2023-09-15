<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentTypeRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:content_types,name,' . $this->route('content_type')],
            'slug' => ['sometimes', 'nullable'],
            'content_type_image' => ['sometimes', 'nullable', 'url'],
            'selected_type_image' => ['sometimes', 'nullable', 'url'],
        ];
    }
}