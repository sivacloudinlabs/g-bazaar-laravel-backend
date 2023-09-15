<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'requested_by' => ['required', 'exists:users,id,is_active,1'],
            'assign_to' => ['required', 'exists:users,id,is_active,1'],
            'closed_by' => ['sometimes', 'nullable', 'exists:users,id,is_active,1'],
            'title' => ['required', 'string'],
            'priority' => ['required', 'string', 'in:' . implode(',', TASK_PRIORITY)],
            'status' => ['sometimes', 'nullable', 'string'],
            'issue' => ['required', 'string'],
            'attachment' => ['sometimes', 'nullable', 'url'],
        ];
    }
}