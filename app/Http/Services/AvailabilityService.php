<?php

namespace App\Http\Services;

use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AvailabilityService
{
    private const CALENDAR_EMPTY_OBJECT = [
        'day' => null,
        'date' => null,
        'legend_id' => null,
        'remarks' => null,
        'color' => null,
        'split_color' => null,
        'gradient' => null,
    ];

    public const GRADIENT = 'bg-gradient-to-br';

    /**
     * Get the calendar.
     *
     * @param  Calendar  $calendar
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public static function getCalendar(Calendar $calendar, Request $request, bool $isPrivate = true): array
    {
        $isCalendarSynced = $calendar->is_synced;
        $passed_date_color = $calendar->passed_date_color;

        $monthYear = Str::of($request->month_year)->explode('-');
        $month = config('constants.months')[$monthYear[0]];
        $year = (int) $monthYear[1];

        $availabilities = $calendar->availabilities()->with('legend')->where('month_year', $request->month_year)->get();
        $legends = $calendar->legends()->get();
        $defaultLegend = $legends->where('is_default', true)->first();

        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $calendar = collect([]);

        for ($date = 1; $date <= $totalDays; $date++) {
            $timestamp = mktime(0, 0, 0, $month, $date, $year);
            $day = date('l', $timestamp);
            $availability = $availabilities->where('day', $date)->first();
            $color = ($availability->legend->color ?? $defaultLegend?->color) ?? '';
            $splitColor = ($availability->legend->split_color ?? $defaultLegend?->split_color) ?? '';
            $gradient = null;

            if ($color && $splitColor) {
                $gradient = "bg-gradient-to-br from-$color to-$splitColor";
            }

            if ($isCalendarSynced && Carbon::now()->addDay(-1)->greaterThan(Carbon::create($year, $month, $date))) {
                $color = $passed_date_color;
                $splitColor = null;
                $gradient = null;
            }

            $calendar->push([
                'day' => Str::lower($day),
                'date' => $date,
                'legend_id' => ($availability->legend_id ?? $defaultLegend?->id) ?? -1,
                'remarks' => $availability->remarks ?? null,
                'color' => $color,
                'split_color' => $splitColor ?? null,
                'gradient' => $gradient,
            ]);
        }

        $weekStart = 'monday';

        if ($isPrivate) {
            $user = User::where('id', $request->organization_id)->first();
            $weekStart = $user->week_start;
        }

        $days = AvailabilityService::addEmptyDays($calendar, $weekStart);
        $weekWiseDays = $calendar->chunk(7);

        return [
            'total_days' => $totalDays,
            'legends' => $legends,
            'weekWiseDays' => $weekWiseDays,
            'days' => $days,
        ];
    }

    /**
     * Add empty days to the calendar.
     *
     * @param  Collection  $calendar
     * @return void
     */
    private static function addEmptyDays(Collection &$calendar, string $weekStart): array
    {
        $daysInAWeek = 7;

        $weekStart = array_search($weekStart, config('constants.days'));
        $days = array_slice(config('constants.days'), $weekStart, 7, true) + array_slice(config('constants.days'), 0, $weekStart, true);
        $days = array_values($days);

        $firstDayIndex = array_search($calendar->first()['day'], $days);
        for ($i = 0; $i < $firstDayIndex; $i++) {
            $calendar->prepend(AvailabilityService::CALENDAR_EMPTY_OBJECT);
        }

        $lastDayIndex = array_search($calendar->last()['day'], $days);
        for ($i = $daysInAWeek - 1; $i > $lastDayIndex; $i--) {
            $calendar->push(AvailabilityService::CALENDAR_EMPTY_OBJECT);
        }

        return $days;
    }

    /**
     * Quick update the calendar.
     *
     * @param  Calendar  $calendar
     * @param  Request  $request
     */
    public static function quickUpdate(Calendar $calendar, Request $request)
    {
        DB::beginTransaction();

        $defaultLegend = $calendar->legends()->where('is_default', true)->first() ?? -1;
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);
        $period = CarbonPeriod::create($from, $to);

        foreach ($period as $date) {
            $day = $date->day;
            $month = Str::lower($date->format('F'));
            $year = $date->year;
            $month_year = $month . '-' . $year;

            if ($request->legend_id === $defaultLegend->id) {
                $calendar->availabilities()->where('day', $day)->where('month_year', $month_year)->delete();
                continue;
            }

            $calendar->availabilities()->updateOrCreate([
                'day' => $day,
                'month_year' => $month_year,
                'start' => $date->format('Y-m-d'),
            ], [
                'user_id' => $request->user_id,
                'legend_id' => $request->legend_id,
                'remarks' => $request->remarks,
            ]);

        }

        DB::commit();
    }
}
