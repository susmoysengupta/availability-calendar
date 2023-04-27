<?php

namespace App\Http\Requests\Availabilities;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AvailabilityStoreRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $monthYear = Str::of($this->month_year)->explode('-');

        $this->merge([
            'month' => config('constants.months')[$monthYear[0]] ?? null,
            'year' => $monthYear[1] ?? null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->month == null || $this->year == null) {
            return [
                'month_year' => ['required', 'string', 'max:20'],
            ];
        }

        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);

        return [
            'month_year' => ['required', 'string', 'max:20'],
            'month' => ['required', 'integer', Rule::in(range(1, 12))],
            'year' => ['required', 'integer', Rule::in(range(date('Y') - 10, date('Y') + 10))],

            'day' => ['required', 'array', 'size:' . $numberOfDays],
            'day.*' => ['required', 'integer', Rule::in(range(1, $numberOfDays))],

            'remarks' => ['required', 'array', 'size:' . $numberOfDays],
            'remarks.*' => ['nullable', 'string', 'max:100'],

            'legend' => ['required', 'array', 'size:' . $numberOfDays],
            'legend.*' => ['required', 'string', 'exists:legends,id'],
        ];
    }
}
