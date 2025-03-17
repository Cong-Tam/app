<?php

namespace App\Http\Requests\Contact;

use App\Rules\DupplicateItem;
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
        $rules = [
            'contacts' => [
                'required',
                'array',
            ],
            'contacts.*.id' => [
                'required',
                Rule::exists('contacts', 'id')->whereNull('deleted_at'),
            ],
            'contacts.*.firstName' => [
                'required',
                'string',
                'max:255',
            ],
            'contacts.*.lastName' => [
                'required',
                'string',
                'max:255',
            ],
            'contacts.*.phone' => [
                'required',
                'string',
                'max:50',
            ],
            'contacts.*.opportunity' => [
                'required',
                'string',
                'max:255',
            ],
            'contacts.*.userId' => [
                'required',
                'numeric',
                Rule::exists('users', 'id')->whereNull('deleted_at'),
            ],
            'contacts.*.tagIds' => [
                'nullable',
                'array',
                new DupplicateItem,
            ],
            'contacts.*.tagIds.*' => [
                'nullable',
                'numeric',
                Rule::exists('tags', 'id'),
            ],
            'contacts.*.listContactIds' => [
                'nullable',
                'array',
                new DupplicateItem,
            ],
            'contacts.*.listContactIds.*' => [
                'nullable',
                'numeric',
                Rule::exists('list_contacts', 'id'),
            ],
        ];

        foreach(request()->input('contacts', []) as $key => $contact) {
            $rules["contacts.$key.email"] = [
                'required',
                'email',
                Rule::unique('contacts', 'email')
                ->whereNull('deleted_at')
                ->ignore($contact['id']),
            ];
        }

        return $rules;
    }
}
