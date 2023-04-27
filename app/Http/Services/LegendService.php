<?php

namespace App\Http\Services;

use App\Models\Availability;
use App\Models\Calendar;
use App\Models\Legend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LegendService
{
    /**
     * Create a new default legend.
     *
     * @param  Request  $request
     * @param  User  $user
     */
    public static function createDefaultLegend(array $validated, User $user): Legend
    {
        $globalLegendCount = Legend::query()
            ->global()
            ->where('organization_id', $user->organization_id)
            ->count();

        $legend = Legend::create($validated + [
            'organization_id' => $user->organization_id,
            'order' => $globalLegendCount,
            'is_default' => $globalLegendCount == 0,
            'is_global' => true,
        ]);

        return $legend;
    }

    /**
     * Add a new legend to all calendars.
     *
     * @param  array  $validated
     * @param  User  $user
     */
    public static function addLegendsToAllCalendars(array $validated, User $user): void
    {
        $calendars = $user?->organization?->calendars ?? [];

        foreach ($calendars as $calendar) {
            Legend::firstOrCreate(
                [
                    'title' => $validated['title'],
                    'calendar_id' => $calendar->id,
                    'organization_id' => $user->organization_id,
                ],
                [
                    'order' => $calendar->legends->count(),
                    'is_default' => false,
                    'is_global' => false,
                ] + $validated
            );
        }
    }

    /**
     * Update a legend.
     *
     * @param  array  $validated
     * @param  Legend  $legend
     * @param  Calendar|null  $calendar
     * @return mixed
     */
    public static function updateLegend(array $validated, Legend $legend, Calendar $calendar = null): Legend
    {
        $legend->update($validated);

        if ($calendar && $calendar->is_synced) {
            if ($legend->is_default && $legend->order === 0) {
                $calendar->legends()->where('title', 'Changeover 1')->update(['color' => $legend->color]);
                $calendar->legends()->where('title', 'Changeover 2')->update(['split_color' => $legend->color]);
            } else if ($legend->order === 1) {
                $calendar->legends()->where('title', 'Changeover 1')->update(['split_color' => $legend->color]);
                $calendar->legends()->where('title', 'Changeover 2')->update(['color' => $legend->color]);
            }
        }

        return $legend;
    }

    /**
     * Create a new legend.
     *
     * @param  array  $validated
     * @param  User  $user
     * @param  Calendar|null  $calendar
     * @return App\Models\Legend
     */
    public static function createLegend(array $validated, User $user, Calendar $calendar = null): Legend
    {
        $legend = Legend::create($validated + [
            'organization_id' => $user->organization_id,
            'order' => $calendar?->legends?->count() ?? 0,
            'is_default' => false,
            'is_global' => false,
            'calendar_id' => $calendar?->id ?? null,
        ]);

        return $legend;
    }

    /**
     * Delete a legend.
     *
     * @param  Legend  $legend
     * @return void
     */
    public static function deleteDefaultLegend(Legend $legend): void
    {
        DB::beginTransaction();

        if ($legend->is_default) {
            return;
        }

        Legend::query()
            ->global()
            ->where('organization_id', $legend->organization_id)
            ->where('order', '>', $legend->order)
            ->decrement('order');

        $legend->delete();

        DB::commit();
    }

    /**
     * @param  Calendar  $calendar
     * @param  Legend  $legend
     * @return null
     */
    public static function deleteLegend(Calendar &$calendar, Legend &$legend): void
    {
        DB::beginTransaction();

        if ($legend->is_default) {
            return;
        }

        $legend->where('calendar_id', $calendar->id)->where('order', '>', $legend->order)->decrement('order');
        $legend->delete();

        Availability::where('calendar_id', $calendar->id)->where('legend_id', $legend->id)->delete();

        DB::commit();
    }
}
