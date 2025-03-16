<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactsRequest extends FormRequest
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
            'contacts' => [
                'required',
                'array',
            ],
            'contacts.*.id' => [
                'required',
                Rule::exists('contacts', 'id')->whereNull('deleted_at'),
            ],
            'contacts.*.first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'contacts.*.last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'contacts.*.phone' => [
                'required',
                'string',
                'max:50',
            ],
            'contacts.*.email' => [
                'required',
                'email',
                // Rule::unique('contacts', 'email')->whereNull('deleted_at')->ignore(fn ($input) => $input['id']),
            ],
            'contacts.*.opportunity' => [
                'required',
                'string',
                'max:255',
            ],
            'contacts.*.user_id' => [
                'required',
                'numeric',
                Rule::exists('users', 'id')->whereNull('deleted_at'),
            ],
        ];
    }
}
