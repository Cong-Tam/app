<?php

namespace App\Http\Requests\Export;

use App\Enums\ExportType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportContactsRequest extends FormRequest
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
            'type' => [
                'required',
                'numeric',
                Rule::in(ExportType::all()),
            ],
            'name' => [
                'required',
                'string',
            ],
            'isAll' => [
                'required',
                Rule::in([0, 1]),
            ],
            'cols' => [
                'nullable',
                'array',
            ],
            'cols.*' => [
                'nullable',
                'numeric',
                Rule::in([0, 1, 2, 3, 4, 5]),
            ],
        ];
    }
}
