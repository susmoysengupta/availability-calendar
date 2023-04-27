<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ config('app.name', 'Laravel') }} </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}" />
</head>

<body x-data="calendar_embed">
    <div class="w-full max-w-xs shadow-lg">
        <div class="p-5 bg-white border rounded-t dark:bg-gray-800">
            @if ($calendar->is_title_visible)
                <h3 class="mb-2 font-semibold leading-loose text-center">{{ __($calendar->title) }}</h3>
            @endif
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-4 w-[60%]">
                    <x-select-input x-model="currMonthYear" name="month_year" x-on:change="currMonthYear = $event.target.value" class="w-[90%] -mx-2 text-xs font-semibold text-gray-600 capitalize">
                        <template x-for="(monthYear,monthIdx) in monthYears" :key="monthIdx">
                            <option x-text="monthYear.label" x-bind:value="monthYear.value" :selected="monthYear.value == currMonthYear"></option>
                        </template>
                    </x-select-input>
                    <svg x-show="isCalendarLoading" class="w-6 h-6 text-purple-600 dark:text-purple-500" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 2A10 10 0 1 0 22 12A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8A8 8 0 0 1 12 20Z" opacity=".5" />
                        <path fill="currentColor" d="M20 12h2A10 10 0 0 0 12 2V4A8 8 0 0 1 20 12Z">
                            <animateTransform attributeName="transform" dur="1s" from="0 12 12" repeatCount="indefinite" to="360 12 12" type="rotate" />
                        </path>
                    </svg>
                </div>

                <div class="flex items-center justify-end">
                    <button type="button" @click="showPreviousMonth()" title="calendar backward" aria-label="calendar backward" class="text-gray-800 hover:text-gray-400 dark:text-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-chevron-left" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="15 6 9 12 15 18" />
                        </svg>
                    </button>
                    <button type="button" @click="showNextMonth()" title="calendar forward" aria-label="calendar forward" class="ml-3 text-gray-800 hover:text-gray-400 dark:text-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-chevron-right" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="9 6 15 12 9 18" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between pt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <template x-for="day,index in days" :key="index">
                                <th class="p-2 bg-gray-100 border border-gray-300 dark:bg-gray-700">
                                    <div class="flex justify-center w-full">
                                        <p x-text="day.substring(0, 2)" class="text-sm font-medium text-center text-gray-800 capitalize dark:text-gray-100"></p>
                                    </div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="week,index in calendarDays" :key="index">
                            <tr>
                                <template x-for="day,dayNo in week" :key="dayNo">
                                    <td class="p-0 text-center border border-gray-300">
                                        <template x-if="day.date != null">
                                            <div class="relative flex items-center justify-center w-full h-full cursor-default">
                                                <p :id="`date-${day.date}`" x-text="day.date" tabindex="0" class="p-1.5 text-xs font-medium text-gray-700 select-none z-10"></p>
                                                <template x-if="day.gradient != null">
                                                    <div class="absolute w-full h-full overflow-hidden clip-left" :style="`background-color: ${day.color}`"></div>
                                                </template>
                                                <template x-if="day.gradient != null">
                                                    <div class="absolute w-full h-full overflow-hidden clip-right" :style="`background-color: ${day.split_color}`"></div>
                                                </template>
                                                <template x-if="day.gradient == null">
                                                    <div class="absolute w-full h-full overflow-hidden" :style="`background-color: ${day.color}`"></div>
                                                </template>
                                            </div>
                                        </template>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        @if ($calendar->is_legend_visible)
            <div class="grid grid-cols-1 gap-4 p-5 border border-t-0 rounded-b dark:bg-gray-700 bg-gray-50">
                <ul class="flex flex-col gap-2">
                    @foreach ($legends as $legend)
                        <li class="flex items-center gap-2">
                            <div class="relative w-5 h-5 overflow-hidden text-gray-600 rounded dark:text-gray-100">
                                @if ($legend->gradient != null)
                                    <div class="absolute w-full h-full overflow-hidden clip-left" style="background-color: {{ $legend->color }}"></div>
                                    <div class="absolute w-full h-full overflow-hidden clip-right" style="background-color: {{ $legend->split_color }}"></div>
                                @else
                                    <div class="absolute w-full h-full overflow-hidden" style="background-color: {{ $legend->color }}"></div>
                                @endif
                            </div>
                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">
                                {{ __($legend->title) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
    </div>

    @endif

    <script>
        window.calendar = @json($calendar ?? null);
        window.months = @json(array_keys(config('constants.months')));
        window.uri = @json($uri ?? null);
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>
<html>
