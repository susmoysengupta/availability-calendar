<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCalendarUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'week_start' => ['required', 'string', Rule::in(config('constants.userCalendarSettings.DAYS_ON_WEEK'))],
            'default_ordering' => ['required', 'string', Rule::in(array_keys(config('constants.userCalendarSettings.ORDERING')))],
            'per_page' => ['required', 'integer', Rule::in(config('constants.userCalendarSettings.PER_PAGE'))],
            'show_week_number' => ['required', 'string', Rule::in(array_keys(config('constants.userCalendarSettings.SHOW_WEEK_NUMBER')))],
        ];
    }
}
