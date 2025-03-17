<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ListContactsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tagId' => [
                'nullable',
                'numeric'
            ],
            'listId' => [
                'nullable',
                'numeric'
            ],
            'userId' => [
                'nullable',
                'numeric'
            ],
            'createdBy' => [
                'nullable',
                'numeric'
            ],
            'email' => [
                'nullable',
                'string'
            ],
            'name' => [
                'nullable',
                'string'
            ],
        ];
    }
}
