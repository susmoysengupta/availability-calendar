<?php
namespace App\Http\Services;

use App\Http\Services\IcsEvent;

class IcsService
{
    /**
     * @param $calendar
     * @param array<IcsEvent> $eventsArray
     */
    public static function create($events, $prodId = 'AvailabilityCalendar.com', $filename = 'calendar')
    {
        $filename = $filename . '.ics';

        $headers = [
            'Content-type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $beginContent = self::getIcsHeader($prodId);
        $content = '';
        foreach ($events as $event) {
            $content .= $event->getIcsContent();
        }
        $endContent = 'END:VCALENDAR';
        $fileContent = $beginContent . $content . $endContent;

        return [
            'headers' => $headers,
            'fileContent' => $fileContent,
            'filename' => $filename,
        ];
    }

    /**
     * Get the ICS header.
     *
     * @param $prodId
     * @return string
     */
    private static function getIcsHeader($prodId): string
    {
        $beginContent = "BEGIN:VCALENDAR\r\n";
        $beginContent .= "VERSION:2.0\r\n";
        $beginContent .= "PRODID:{$prodId}\r\n";
        $beginContent .= "CALSCALE:GREGORIAN\r\n";
        $beginContent .= "METHOD:PUBLISH\r\n";

        return $beginContent;
    }

}
