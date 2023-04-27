<?php

namespace App\Http\Controllers;

use App\Http\Services\ImportService;
use App\Models\Calendar;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importICal(Calendar $calendar, Request $request)
    {
        $request->validate([
            'feeds' => 'required|array',
            'feeds.*' => 'required|url',
            'split' => 'sometimes|boolean',
            'ical_feed_book_type' => 'sometimes|in:any,all',
            'passed_date_color' => 'required',
        ]);

        $importService = new ImportService();
        $importService->importICal($calendar, $request);

        return redirect()->route('calendars.show', $calendar)
            ->with('success', 'Calendar imported successfully.');
    }

    /**
     * @param Calendar $calendar
     */
    public function deactivateSync(Calendar $calendar)
    {
        $calendar->update([
            'is_synced' => false,
            'ical_feeds' => null,
            'should_split' => false,
        ]);

        return redirect()->route('calendars.availability.index', $calendar)
            ->with('success', 'Calendar deactivated successfully.');
    }

}
