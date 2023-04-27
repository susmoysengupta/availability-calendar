<?php

namespace App\Http\Requests\Calendars;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalendarPublicRequest extends FormRequest
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
    public function rules()
    {
        $startDateCheck = fn () => $this->view == 'monthly' && $this?->start_date != 'current';

        return [
            'view' => ['required', 'in:monthly,yearly,multiple'],
            'lang' => ['required', 'in:en'],
            'title' => ['required', 'string', 'in:"no", "yes"'],
            'booking_info' => ['required', 'string', 'in:"no", "yes"'],
            'no_of_months' => ['required_if:view,monthly', 'integer', 'min:1', 'max:12'],
            'week_number' => ['required_if:view,monthly', 'string', 'in:"no", "us", "iso"'],
            'first_day' => ['required_if:view,monthly', 'integer', 'in:0,1,2,3,4,5,6'],
            'start_date' => ['required_if:view,monthly', 'string'],
            'month' => [Rule::requiredIf($startDateCheck), 'integer', 'min:1', 'max:12'],
            'year' => [Rule::requiredIf($startDateCheck), 'integer', 'min:1900', 'max:2100'],
            'history' => ['required', 'string', 'in:"yes", "default", "gray"'],
        ];
    }

    /**
     * @param $validator
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        abort(503, 'Invalid request');
    }
}
