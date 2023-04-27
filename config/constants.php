<?php

$userCalendarSettings = [
    'DAYS_ON_WEEK' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
    'ORDERING' => ['asc' => 'Oldest on top', 'desc' => 'Newest on top', 'alphabetical' => 'Alphabetical'],
    'PER_PAGE' => [5, 15, 30, 50],
    'SHOW_WEEK_NUMBER' => ['hide' => 'Hide', 'us' => 'US', 'iso' => 'Standard ISO (Europe)'],
];

$twColors = ['gray', 'red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'];
$twVariants = [100, 200, 300, 400, 500, 600, 700, 800, 900];
$twMainColors = [];
foreach ($twColors as $color) {
    foreach ($twVariants as $variant) {
        $twMainColors[] = $color . '-' . $variant;
    }
}

$months = ['january' => 1, 'february' => 2, 'march' => 3, 'april' => 4, 'may' => 5, 'june' => 6, 'july' => 7, 'august' => 8, 'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12];

$deleteCalendarDataPeriods = [
    'all' => 'All Time',
    'past-time' => 'Past Time',
    'year-1' => 'Older than 1 year',
    'year-2' => 'Older than 2 years',
];

return [
    'userCalendarSettings' => $userCalendarSettings,
    'twColors' => $twColors,
    'twVariants' => $twVariants,
    'twMainColors' => $twMainColors,
    'months' => $months,
    'days' => $userCalendarSettings['DAYS_ON_WEEK'],
    'deleteCalendarDataPeriods' => $deleteCalendarDataPeriods,
];
