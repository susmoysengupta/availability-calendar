<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefaultLegend\LegendStoreRequest;
use App\Http\Requests\DefaultLegend\LegendUpdateRequest;
use App\Http\Services\LegendService;
use App\Models\Calendar;
use App\Models\Legend;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LegendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Calendar  $calendar
     * @return Illuminate\View\View
     */
    public function index(Calendar $calendar): View
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if (auth()->user()->hasRole('editor')) {
            return redirect()->route('calendars.index');
        }

        $legends = $calendar->legends()->orderBy('order')->get();

        return view('calendars.legends.index', compact('calendar', 'legends'));
    }

    /**
     * @param  Calendar  $calendar
     */
    public function create(Calendar $calendar): View
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if (auth()->user()->hasRole('editor')) {
            return redirect()->route('calendars.index');
        }

        return view('calendars.legends.create', compact('calendar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\DefaultLegend\LegendStoreRequest  $request
     * @param  Calendar  $calendar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LegendStoreRequest $request, Calendar $calendar): RedirectResponse
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        LegendService::createLegend($request->validated(), $request->user(), $calendar);

        return redirect()->route('calendars.legends.index', $calendar)->with('success', 'Legend created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Calendar  $calendar
     * @param  Legend  $legend
     * @return \Illuminate\View\View
     */
    public function edit(Calendar $calendar, Legend $legend): View
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if (auth()->user()->hasRole('editor')) {
            return redirect()->route('calendars.index');
        }

        return view('calendars.legends.edit', compact('calendar', 'legend'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\DefaultLegend\LegendUpdateRequest  $request
     * @param  Calendar  $calendar
     * @param  Legend  $legend
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LegendUpdateRequest $request, Calendar $calendar, Legend $legend): RedirectResponse
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if (auth()->user()->hasRole('editor')) {
            return redirect()->route('calendars.index');
        }

        LegendService::updateLegend($request->validated(), $legend, $calendar);

        if ($calendar->is_synced) {
            return redirect()->route('calendars.show', $calendar)->with('success', 'Legend updated');
        }

        return redirect()->route('calendars.legends.index', $calendar)->with('success', 'Legend updated.');
    }

    /**
     * Delete the legend.
     *
     * @param  Calendar  $calendar
     * @param  Legend  $legend
     */
    public function destroy(Calendar $calendar, Legend $legend): RedirectResponse
    {
        if ($calendar->organization_id != auth()->user()->organization_id) {
            abort(404);
        }

        if (auth()->user()->hasRole('editor')) {
            return redirect()->route('calendars.index');
        }

        LegendService::deleteLegend($calendar, $legend);

        return redirect()->route('calendars.legends.index', $calendar)->with('success', 'Legend deleted.');
    }

    /**
     * Update the default of the legend.
     *
     * @param  Legend  $legend
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDefault(Legend $legend): RedirectResponse
    {
        DB::beginTransaction();

        if ($legend->is_global) {
            Legend::global()->where('organization_id', $legend->organization_id)->update(['is_default' => false]);
        } else {
            Legend::where('calendar_id', $legend->calendar_id)->update(['is_default' => false]);
        }

        $legend->is_default = true;
        $legend->save();

        DB::commit();

        return redirect()->back()->with('success', 'Legend default updated.');
    }

    /**
     * Update the visibility of the legend.
     *
     * @param  Legend  $legend
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateVisibility(Legend $legend): RedirectResponse
    {
        $legend->is_visible = !$legend->is_visible;
        $legend->save();

        return redirect()->back()->with('success', 'Legend visibility updated.');
    }

    /**
     * Update the sync of the legend.
     *
     * @param  Legend  $legend
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSync(Legend $legend): RedirectResponse
    {
        $legend->is_synced = !$legend->is_synced;
        $legend->save();

        return redirect()->back()->with('success', 'Legend sync updated.');
    }

    /**
     * Update the order of the legend.
     *
     * @param  Legend  $legend
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrder(Legend $legend, Request $request): RedirectResponse
    {
        $request->validate([
            'order' => 'required|integer|min:0',
        ]);

        $otherLegend = Legend::query()
            ->when($legend->is_global, fn($query) => $query->global()->where('organization_id', $legend->organization_id))
            ->when(!$legend->is_global, fn($query) => $query->where('calendar_id', $legend->calendar_id))
            ->where('order', $request->order)
            ->first();

        if ($otherLegend) {
            $otherLegend->order = $legend->order;
            $legend->order = $request->order;

            $otherLegend->save();
            $legend->save();
        }

        if ($legend->is_global) {
            return redirect()->route('settings.index')->with('success', 'Global legend order updated.');
        }

        return redirect()->route('calendars.legends.index', $legend->calendar_id)
            ->with('success', 'Legend order updated.');
    }

    /**
     * @param  Request  $request
     */
    public function getLegends(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer|exists:calendars,id',
        ]);
        $legends = Legend::query()
            ->where('calendar_id', $request->calendar_id)
            ->get(['id', 'title', 'color', 'split_color', 'is_default']);

        return response()->json($legends, 200);
    }
}
