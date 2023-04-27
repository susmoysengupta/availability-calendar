<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calendars\CalendarStoreRequest;
use App\Http\Requests\Calendars\CalendarUpdateRequest;
use App\Http\Services\AvailabilityService;
use App\Http\Services\IcsEvent;
use App\Http\Services\IcsService;
use App\Models\Calendar;
use App\Models\Legend;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = auth()->user();
        $defaultOrdering = $user->organization->default_ordering;
        $userCalendars = $user->assignedCalendars()->pluck('id')->toArray();
        $role = $user->roles->first()->name ?? '';

        $calendars = Calendar::query()
            ->where('organization_id', $user->organization_id)
            ->when($role == 'editor', fn($query) => $query->whereIn('id', $userCalendars))
            ->when(request()->search, fn($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->when($defaultOrdering == 'alphabetical', fn($query) => $query->orderBy('title', 'asc'))
            ->when($defaultOrdering != 'alphabetical', fn($query) => $query->orderBy('created_at', $defaultOrdering))
            ->paginate($user->organization->per_page, ['*'], 'calendars');

        return view('calendars.index', compact('calendars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Calendars\CalendarStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CalendarStoreRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        $orgId = request()->user()->organization_id;
        $calendar = Calendar::create($request->validated() + ['organization_id' => $orgId]);
        $defaultLegends = Legend::global($orgId)->get();

        foreach ($defaultLegends as $defaultLegend) {
            $defaultLegend->replicate()->fill([
                'calendar_id' => $calendar->id,
                'is_global' => false,
            ])->save();
        }

        DB::commit();

        return redirect()->route('calendars.index')->with('success', 'Your calendar has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function show(Calendar $calendar): View | RedirectResponse
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if (!$calendar->is_synced) {
            return redirect()->route('calendars.availability.index', $calendar);
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

            $legend->color = $color;
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

        $iCalFeeds = $calendar->ical_feeds;
        $should_split = $calendar->should_split;
        $iCal_feed_book_type = $calendar->iCal_feed_book_type;

        $view = $calendar->is_synced ? 'calendars.show-synced' : 'calendars.availability';

        return view($view, compact(
            'calendar',
            'legends',
            'assignedEditors',
            'availableEditors',
            'iCalFeeds',
            'should_split',
            'iCal_feed_book_type'
        ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\View\View
     */
    public function edit(Calendar $calendar): View
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        return view('calendars.edit', compact('calendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Calendars\CalendarUpdateRequest  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CalendarUpdateRequest $request, Calendar $calendar): RedirectResponse
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        $calendar->update($request->validated());

        return redirect()->route('calendars.index')->with('success', 'Your calendar has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Calendar $calendar): RedirectResponse
    {
        if (auth()->user()->hasRole('editor')) {
            return redirect()->route('calendars.index')->with('error', 'You are not allowed to delete calendars.');
        }

        DB::beginTransaction();
        $calendar->legends()->delete();
        $calendar->delete();
        DB::commit();

        return redirect()->route('calendars.index')->with('success', 'Your calendar has been deleted.');
    }

    /**
     * Show the embed page for the specified resource.
     *
     * @param  Calendar  $calendar
     */
    public function embed(Calendar $calendar): View
    {
        return view('calendars.embed', compact('calendar'));
    }

    /**
     * Show the embed page for the specified resource (Beta).
     *
     * @param  Calendar  $calendar
     */
    public function embedBeta(Calendar $calendar): View
    {
        return view('calendars.embed-beta', compact('calendar'));
    }

    /**
     * Download the specified resource as .csv.
     *
     * @param  Calendar  $calendar
     */
    public function download(Calendar $calendar, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $filename = $calendar->title . '_' . $request->start_date . '_' . $request->end_date . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($calendar, $request) {
            $file = fopen('php://output', 'w');

            $availabilities = $calendar->availabilities()->with('legend')->get();
            $defaultLegend = $calendar->legends()->where('is_default', true)->first();

            $start_date = strtotime($request->start_date);
            $end_date = strtotime($request->end_date);
            $secondsInaDay = 86400;

            for ($i = $start_date; $i <= $end_date; $i += $secondsInaDay) {
                $date = date('Y-m-d', $i);
                $availability = $availabilities->where('start', $date)->first();
                $legend = '"' . ($availability ? $availability->legend->title : $defaultLegend->title) . '"';
                $remarks = '"' . ($availability ? $availability->remarks : '') . '"';

                fputcsv($file, [$date, $legend, $remarks], ',', '\'');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download the specified resource as .ics.
     *
     * @param Calendar $calendar
     */
    public function downloadICal(Calendar $calendar)
    {
        $availabilities = $calendar->availabilities()->with('legend')->get();

        $legends = $calendar->legends()->get();
        $defaultLegend = $legends->where('is_default', true)->first();
        $isDefaultLegendSynced = $defaultLegend->is_synced;

        $organizer = 'MAILTO:info@availabilitycalendar.com';

        $events = [];

        if ($isDefaultLegendSynced) {
            $start_date = Carbon::now()->subMonth();
            $end_date = Carbon::now()->addYears(10);
            $period = CarbonPeriod::create($start_date, $end_date);

            foreach ($period as $date) {
                $availability = $availabilities->where('start', $date->format('Y-m-d'))->first();
                if ($availability && !$availability->legend->is_synced) {
                    continue;
                }
                $events[] = $this->makeIcsEvent([
                    'calendar' => $calendar,
                    'date' => $date,
                    'legend' => $availability ? $availability->legend->title : $defaultLegend->title,
                    'organizer' => $organizer,
                    'remarks' => $availability ? ($availability->remarks) : '',
                ], $calendar->should_include_details);
            }
        } else {
            foreach ($availabilities as $availability) {
                if (!$availability->legend->is_synced) {
                    continue;
                }

                $events[] = $this->makeIcsEvent([
                    'calendar' => $calendar,
                    'date' => Carbon::parse($availability->start),
                    'legend' => $availability->legend->title,
                    'organizer' => $organizer,
                    'remarks' => $availability->remarks,
                ], $calendar->should_include_details);
            }
        }

        $proId = "AvailabilityCalendar.com - Calendar ID: {$calendar->id}";
        $icsService = IcsService::create($events, $proId, $calendar->title);
        $fileContent = $icsService['fileContent'];
        $headers = $icsService['headers'];
        $filename = $icsService['filename'];

        $callback = function () use ($fileContent) {
            echo $fileContent;
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    /**
     * @param $data
     */
    private function makeIcsEvent($data, $shouldIncludeDetails = true)
    {
        $dtStamp = $data['date']->format('Ymd\THis\Z');
        $dtStart = $data['date']->format('Ymd');
        $dtEnd = $data['date']->addDay()->format('Ymd');
        $uid = $dtStamp . '-' . $data['calendar']->id . '@availabilitycalendar.com';

        $event = new IcsEvent($uid, $dtStamp, $dtStart, $dtEnd);
        $event->setSummary($data['legend'])->setOrganizer($data['organizer']);
        if ($shouldIncludeDetails) {
            $event->setDescription($data['remarks']);
        }

        return $event;
    }

    /**
     * @param Calendar $calendar
     */
    public function getCalendar(Calendar $calendar)
    {
        return response()->json($calendar);
    }

    /**
     * @param Request $request
     * @param Calendar $calendar
     */
    public function updateCalendar(Request $request, Calendar $calendar)
    {
        $request->validate([
            'should_include_details' => ['required', 'boolean'],
        ]);

        $calendar->update($request->only('should_include_details'));

        return response()->json($calendar, 200);
    }

    /**
     * @param Calendar $calendar
     * @param User $editor
     */
    public function destroyAssignedEditor(Calendar $calendar, User $editor)
    {
        $calendar->editors()->detach($editor->id);

        return redirect()->route('calendars.availability.index', $calendar)
            ->with('success', 'Editor removed successfully.');
    }

    /**
     * Assign editor to calendar.
     *
     * @param Calendar $calendar
     * @param Request $request
     */
    public function storeAssignedEditor(Calendar $calendar, Request $request)
    {
        $request->validate([
            'editor_id' => ['required', 'exists:users,id'],
        ]);

        $calendar->editors()->attach($request->editor_id);

        return redirect()->route('calendars.availability.index', $calendar)
            ->with('success', 'Editor assigned successfully.');
    }

    /**
     * @param Calendar $calendar
     * @param Request $request
     */
    public function updateEmbedCode(Calendar $calendar, Request $request)
    {
        $request->validate([
            'title' => 'sometimes|boolean',
            'legend' => 'sometimes|boolean',
        ]);

        // dd($request->all());

        $calendar->update([
            'is_title_visible' => $request->title ?? false,
            'is_legend_visible' => $request->legend ?? false,
        ]);

        return redirect()->route('calendars.embed-beta', $calendar)
            ->with('success', 'Embed code updated successfully.');
    }
}
