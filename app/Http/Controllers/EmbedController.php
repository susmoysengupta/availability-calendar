<?php

namespace App\Http\Controllers;

use App\Http\Services\AvailabilityService;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmbedController extends Controller
{
    /**
     * Returns the preview of the calendar
     *
     * @param  Calendar  $calendar
     * @param  Request  $request
     */
    public function index(Calendar $calendar, Request $request)
    {
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

        $uri = Str::after($request->getRequestUri(), '?');

        return view('calendars.preview', compact('calendar', 'legends', 'uri'));
    }

    /**
     * Returns the embed code for the calendar
     *
     * @param  Calendar  $calendar
     * @param  Request  $request
     */
    public function embedJs(Calendar $calendar, Request $request)
    {
        $route = route('embed.index', $calendar);
        $route = $route . '?' . Str::after($request->getRequestUri(), '?');

        $time = time();
        $id = "ac-{$calendar->id}-{$time}";
        $iframeId = $id . '-iframe';
        $height = $calendar->is_legend_visible ? 500 : 350;

        $fileContent = Storage::get('embed-code.js');
        $fileContent = str_replace('{$calendarId}', $id, $fileContent);
        $fileContent = str_replace('{$route}', $route, $fileContent);
        $fileContent = str_replace('{$iframeId}', $iframeId, $fileContent);
        $fileContent = str_replace('{$height}', $height, $fileContent);

        return response()->make($fileContent, 200, [
            'Content-Type' => 'application/javascript',
        ]);
    }
}
