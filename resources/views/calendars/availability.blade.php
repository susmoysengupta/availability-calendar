<x-app-layout>
    <x-slot name="title">
        {{ __('Set Availability') }}
    </x-slot>
    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <x-breadcrumbs-link href="{{ route('calendars.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                {{ __('Calenders') }}
            </x-breadcrumbs-link>
        </li>
        <li class="flex items-center">
            <x-breadcrumbs-link :isCurrent="true">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Set Availability') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    {{-- <div class="flex items-center justify-center gap-3 px-4 py-2 text-xl text-gray-700 border border-gray-200 rounded-lg dark:text-gray-400 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <h3> {{ __($calendar->title) }} </h3>
        <a href="{{ route('calendars.edit', $calendar) }}" title="Edit names & settings">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        </a>
    </div> --}}

    <div class="flex items-center gap-2">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-bold leading-7 text-gray-700 sm:truncate sm:text-2xl sm:tracking-tight dark:text-gray-100 link hover:text-gray-600 dark:hover:text-gray-200">{{ __($calendar->title) }}</h2>
                <a href="{{ route('calendars.edit', $calendar) }}" title="Edit this calendar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </a>
            </div>
            <div class="flex flex-col mt-1 sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="flex items-center mt-1 text-xs text-gray-500">
                    <!-- Heroicon name: mini/calendar -->
                    <svg class="mr-1.5 flex-shrink-0 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                    </svg>
                    Last updated {{ $calendar->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    <div x-data="calendar()" class="grid items-start gap-5 my-8 lg:grid-cols-2">
        <!-- Set Availability -->
        <form action="{{ route('calendars.availability.store', $calendar) }}" method="POST" enctype="multipart/form-data" class="p-4 text-gray-700 bg-white rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 lg:row-span-2">
            @csrf
            <div class="grid gap-2">
                <template x-for="week,index in calendarDays" x-key="index">
                    <div class="flex flex-wrap gap-2 text-xs md:flex-no-wrap">
                        <template x-for="day,dayNo in week" :key="dayNo">
                            <template x-if="day.date !== null">
                                <div class="flex items-center w-full gap-2" x-id="['legend-color']">
                                    <span :id="`week-date-${day.date}`" :value="`w-${index}-d-${day.date}`" class="hidden"></span>
                                    <div class="relative flex items-center justify-center h-8 overflow-hidden border rounded w-14">
                                        <span :id="`legend-color-${day.date}`" x-text="day.date" class="z-20 font-bold rounded dark:text-gray-700"></span>
                                        <div :id="`date-color-${day.date}`" class="absolute w-full h-full">
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
                                    </div>

                                    <span x-text="day.day.substring(0, 2)" class="flex items-center justify-center flex-shrink-0 w-8 h-8 font-bold text-gray-800 uppercase dark:text-gray-400"></span>

                                    <x-select-input x-bind:id="`legend-${day.date}`" @change="changeLegendColor($el, day.date)" name="legend[]" class="w-1/2 text-xs font-semibold">
                                        <template x-for="legend in legends" :key="legend.id">
                                            <option :value="legend.id" :selected="legend.id === day.legend_id" class="text-xs font-semibold text-gray-600 dark:text-gray-400" x-text="legend.title"></option>
                                        </template>
                                    </x-select-input>

                                    <x-text-input name="remarks[]" type="text" x-bind:value="day.remarks" class="w-full text-xs font-semibold text-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-600" placeholder="Remarks" />
                                    <input name="day[]" type="hidden" :value="day.date" />
                                </div>
                            </template>
                        </template>
                    </div>
                </template>
            </div>

            <input type="hidden" x-model="currMonthYear" name="month_year" readonly>

            <div x-show="isCalendarLoading" class="flex items-center justify-center w-full h-64 text-gray-500 bg-gray-100 rounded-md dark:bg-gray-700 dark:text-gray-400">
                {{ __('Loading...') }}
            </div>

            <div class="flex items-center justify-center mt-6 mb-4">
                <x-primary-button type="submit"> {{ __('Save') }} </x-primary-button>
            </div>
        </form>

        @include('calendars.partials.calendar-grid-v2')

        <div class="lg:row-span-2">
            <!-- Quick Edit -->
            @include('calendars.partials.quick-edit-form')

            <!-- Assigned Editors -->
            @include('calendars.partials.assigned-editor-form')

            <!-- Embed Calendar -->
            <div class="mb-5 text-gray-700 bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200">
                <a href="{{ route('calendars.embed-beta', $calendar) }}" class="flex w-full p-4 text-sm font-semibold focus:outline-none">Embed Calendar</a>
            </div>

            <!-- Import External Calendar -->
            <div class="mb-3 text-gray-700 bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200">
                <button data-modal-target="import-external-modal" data-modal-toggle="import-external-modal" class="flex w-full p-4 text-sm font-semibold focus:outline-none">
                    Import External Calendar
                </button>
                <!-- Main modal -->
                <div id="import-external-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-full h-full max-w-md md:h-auto">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="import-external-modal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="px-6 py-6 lg:px-8">
                                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Import External Calendar</h3>
                                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        Sync (import) your external Calendar with AvailabilityCalendar.com. Note that when you import an external calendar, the booking details you entered will be lost.
                                    </div>
                                </div>
                                <form action="{{ route('calendars.import-ical', $calendar) }}" method="POST" onsubmit="return confirm('When you sync an external calendar, the booking details you previously entered for this calendar will be lost. Are you sure you want to sync?')" class="space-y-6">
                                    @csrf
                                    <div>
                                        <label for="feed" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">iCal (.ics) link from the external calendar:</label>
                                        <input type="text" name="feeds[]" id="feed" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                    </div>
                                    <input type="hidden" name="ical_feed_book_type" value="any">
                                    <input type="hidden" name="split" value="0">

                                    <x-primary-button type="submit"> {{ __('Import Calendar') }} </x-primary-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @section('scripts')
        <script>
            window.calendar = @json($calendar ?? null);
            window.organizationId = @json(request()->user()->organization_id ?? null);
            window.legends = @json($legends ?? null);
            window.months = @json(array_keys(config('constants.months')));
            window.userId = @json(request()->user()->id ?? null);
        </script>
    @endsection
</x-app-layout>
