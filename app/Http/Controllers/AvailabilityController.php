<?php

namespace App\Http\Controllers;

use App\Http\Requests\Availabilities\AvailabilityStoreRequest;
use App\Http\Services\AvailabilityService;
use App\Models\Calendar;
use App\Models\Legend;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Calendar $calendar)
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if ($calendar->is_synced) {
            return redirect()->route('calendars.show', $calendar);
        }

        $legends = $calendar->legends()->get();
        $legends->map(function ($legend) {
            $color = $legend->color ?? null;
            $splitColor = $legend->split_color ?? null;
            $gradient = null;
            $gradCol = AvailabilityService::GRADIENT;

            if ($color && $splitColor) {
                $gradient = "$gradCol from-$color to-$splitColor";
            }

            $legend->color = $color ?? null;
            $legend->split_color = $splitColor ?? null;
            $legend['gradient'] = $gradient;
        });

        $assignedEditors = $calendar->assignUser()->get();
        $availableEditors = User::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->whereNotIn('id', $assignedEditors->pluck('id'))
            ->whereHas('roles', function ($query) {
                $query->where('name', 'editor');
            })
            ->get();

        return view('calendars.availability', compact(
            'calendar',
            'legends',
            'assignedEditors',
            'availableEditors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Calendar $calendar, AvailabilityStoreRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        $defaultLegend = Legend::default($calendar)->first();
        $calendar->availabilities()->where('month_year', $request->month_year)->delete();

        foreach ($request->day as $index => $day) {
            if ($request->legend[$index] != $defaultLegend->id || $request->remarks[$index] != null) {
                $monthYear = Str::of($request->month_year)->explode('-');
                $month = config('constants.months')[$monthYear[0]];
                $year = $monthYear[1];

                $calendar->availabilities()->create([
                    'day' => $day,
                    'month_year' => $request->month_year,
                    'start' => Carbon::create($year, $month, $day)->format('Y-m-d'),
                    'user_id' => auth()->user()->id,
                    'legend_id' => $request->legend[$index],
                    'remarks' => $request->remarks[$index],
                ]);
            }
        }
        DB::commit();

        return redirect()->route('calendars.availability.index', $calendar)
            ->with('success', 'Availability saved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Calendar  $calendar
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function quickUpdate(Calendar $calendar, Request $request): RedirectResponse
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'legend_id' => 'required|exists:legends,id',
            'remarks' => 'nullable|string|max:255',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);
        AvailabilityService::quickUpdate($calendar, $request);

        return redirect()->route('calendars.availability.index', $calendar)
            ->with('success', 'Availability updated successfully');
    }

    /**
     * @param  Calendar  $calendar
     * @param  Request  $request
     */
    public function getCalendar(Calendar $calendar, Request $request)
    {
        $request->validate([
            'month_year' => 'required',
            'organization_id' => 'required|exists:users,id',
        ]);
        $calendar = AvailabilityService::getCalendar($calendar, $request);

        return response()->json($calendar, 200);
    }

    /**
     * @param  Calendar  $calendar
     * @param  Request  $request
     */
    public function getPublicCalendar(Calendar $calendar, Request $request)
    {
        $request->validate(['month_year' => 'required']);
        $calendar = AvailabilityService::getCalendar($calendar, $request, false);

        return response()->json($calendar, 200);
    }
}
