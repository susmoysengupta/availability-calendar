<?php

namespace App\Http\Services;

use App\Models\Calendar;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportService
{
    /**
     * @param $calendar
     * @param $request
     */
    public function importICal($calendar, $request = null)
    {
        DB::beginTransaction();

        if ($request && !$calendar->is_synced) {
            $calendar->legends()->delete();
            foreach ($calendar->syncedLegends() as $legend) {
                LegendService::createLegend($legend, auth()->user(), $calendar);
            }
        }

        $calendar->update([
            'is_synced' => true,
            'ical_feeds' => $request ? $request->feeds : $calendar->ical_feeds,
            'ical_feed_book_type' => $request ? $request->ical_feed_book_type : $calendar->ical_feed_book_type,
            'should_split' => $request ? $request->split : $calendar->should_split,
            'passed_date_color' => $request ? $request->passed_date_color : $calendar->passed_date_color,
        ]);

        $calendar->availabilities()->delete();
        $events = $this->getEvents($calendar->ical_feeds);
        $this->saveEvents($calendar, $events, $calendar->ical_feed_book_type, $calendar->should_split);

        DB::commit();

    }

    /**
     * Get feeds.
     *
     * @param array $feeds
     * @return array $events
     */
    private function getEvents($feeds)
    {
        $events = [];
        foreach ($feeds as $feed) {
            $dataString = file_get_contents($feed);
            $events[] = $this->parseICal($dataString);
        }

        return $events;
    }

    /**
     * Parse iCal data.
     *
     * @param string $dataString
     * @return array $events
     */
    private function parseICal($dataString)
    {
        $lines = explode("\r\n", $dataString);
        $events = [];
        $event = [];

        foreach ($lines as $line) {
            if (strpos($line, 'DTSTART') === 0) {
                $event['start'] = $this->getDTStart($line);
            }
            if (strpos($line, 'DTEND') === 0) {
                $event['end'] = $this->getDTEnd($line);
            }

            if (strpos($line, 'END:VEVENT') === 0) {
                $events[] = $event;
                $event = [];
            }
        }

        return $events;
    }

    /**
     * Get start date from line.
     *
     * @param string $line
     */
    private function getDTStart($line)
    {
        $offset = strlen('DTSTART;VALUE=DATE:');

        return substr($line, $offset);
    }

    /**
     * Get end date from line.
     *
     * @param string $line
     */
    private function getDTEnd($line)
    {
        $offset = strlen('DTEND;VALUE=DATE:');

        return substr($line, $offset);
    }

    /**
     * Save events to database.
     *
     * @param App\Models\Calendar $calendar
     * @param array $events
     * @param string $bookingType
     */
    private function saveEvents(Calendar $calendar, $events, $bookingType, $shouldSplit)
    {
        $events = collect($events)->flatten(1);
        $dateFrequency = $events->groupBy('start')->map(fn($event) => count($event));

        if ($bookingType === 'all') {
            $events = $events->filter(fn($event) => $dateFrequency[$event['start']] > 1);
        }

        $events = $this->mergeIntervals($events);

        foreach ($events as $event) {
            $start = $event['start'];
            $end = $event['end'];
            $period = CarbonPeriod::create($start, $end);

            foreach ($period as $date) {
                if ($shouldSplit === false && $date->format('Y-m-d') === $end->format('Y-m-d')) {
                    continue;
                }

                $legend = $calendar->legends()->where('order', 1)->first();

                if ($date->format('Y-m-d') === $start->format('Y-m-d') && $shouldSplit) {
                    $legend = $calendar->legends()->where('order', 2)->first();
                }

                if ($date->format('Y-m-d') === $end->format('Y-m-d') && $shouldSplit) {
                    $legend = $calendar->legends()->where('order', 3)->first();
                }

                $calendar->availabilities()->create([
                    'day' => $date->format('j'),
                    'start' => $date->format('Y-m-d'),
                    'month_year' => Str::lower($date->format('F-Y')),
                    'legend_id' => $legend->id,
                    'user_id' => auth()->id(),
                ]);

            }
        }
    }

    /**
     * Merge intervals.
     *
     * @param $events
     * @return mixed
     */
    private function mergeIntervals($events)
    {
        $events = $events->map(function ($event) {
            return [
                'start' => Carbon::parse($event['start']),
                'end' => Carbon::parse($event['end']),
            ];
        });

        $events = $events->sortBy('start');
        $merged = [];

        foreach ($events as $event) {
            if (!$merged) {
                $merged[] = $event;
                continue;
            }

            $last = end($merged);
            if ($event['start'] <= $last['end']) {
                $last['end'] = max($last['end'], $event['end']);
                array_pop($merged);
                $merged[] = $last;
            } else {
                $merged[] = $event;
            }
        }

        return collect($merged);
    }
}
