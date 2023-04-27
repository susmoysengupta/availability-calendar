<?php

namespace App\Http\Requests\DefaultLegend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DefaultLegendStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'add_to_all' => $this->add_to_all === 'on',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('legends', 'title')
                    ->where('organization_id', $this->user()->organization_id)
                    ->where('calendar_id', null),
            ],
            'color' => [
                'required',
                'string',
                'max:7',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',

            ],
            'split_color' => [
                'nullable',
                'string',
                'max:7',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            ],
            'add_to_all' => ['sometimes', 'boolean'],
        ];
    }
}
