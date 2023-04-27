<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefaultLegend\DefaultLegendStoreRequest;
use App\Http\Requests\DefaultLegend\DefaultLegendUpdateRequest;
use App\Http\Services\LegendService;
use App\Models\Legend;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DefaultLegendController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('settings.legends.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DefaultLegend\DefaultLegendStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DefaultLegendStoreRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        LegendService::createDefaultLegend($request->validated(), $request->user());

        if ($request->add_to_all) {
            LegendService::addLegendsToAllCalendars($request->validated(), $request->user());
        }

        DB::commit();

        return redirect()->route('settings.index')
            ->with('success', 'Legend created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legend  $legend
     * @return \Illuminate\View\View
     */
    public function edit(Legend $default_legend): View
    {
        $legend = $default_legend;

        return view('settings.legends.edit', compact('legend'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\DefaultLegend\DefaultLegendUpdateRequest  $request
     * @param  \App\Models\Legend  $legend
     * @return \\Illuminate\Http\RedirectResponse
     */
    public function update(DefaultLegendUpdateRequest $request, Legend $default_legend): RedirectResponse
    {
        LegendService::updateLegend($request->validated(), $default_legend);

        return redirect()->route('settings.index')->with('success', 'Legend updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legend  $legend
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Legend $default_legend): RedirectResponse
    {
        LegendService::deleteDefaultLegend($default_legend);

        return redirect()->route('settings.index')->with('error', 'Legend deleted successfully.');
    }
}
