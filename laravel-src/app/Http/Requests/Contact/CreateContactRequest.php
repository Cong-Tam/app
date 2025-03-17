<?php

namespace App\Http\Requests\Contact;

use App\Rules\DupplicateItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateContactRequest extends FormRequest
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
            'firstName' => [
                'required',
                'string',
                'max:255',
            ],
            'lastName' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->whereNull('deleted_at'),
            ],
            'phone' => [
                'required',
                'string',
                'max:50',
            ],
            'opportunity' => [
                'required',
                'string',
                'max:255',
            ],
            'userId' => [
                'required',
                'numeric',
                Rule::exists('users', 'id')->whereNull('deleted_at'),
            ],
            'tagIds' => [
                'nullable',
                'array',
                new DupplicateItem,
            ],
            'tagIds.*' => [
                'nullable',
                'numeric',
                Rule::exists('tags', 'id'),
            ],
            'listContactIds' => [
                'nullable',
                'array',
                new DupplicateItem,
            ],
            'listContactIds.*' => [
                'nullable',
                'numeric',
                Rule::exists('list_contacts', 'id'),
            ],
        ];
    }
}
