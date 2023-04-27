<div x-data="syncedCalendar()" class="flex items-center justify-center gap-8">
    {{-- Current Month --}}
    <div class="w-[17rem] shadow-lg">
        <div class="p-5 bg-white border rounded-md dark:bg-gray-700 dark:border-gray-600">
            <div class="flex items-center justify-between w-full gap-8">
                <button type="button" @click="showPreviousMonth()" title="calendar backward" aria-label="calendar backward" class="text-gray-800 hover:text-gray-400 dark:text-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-chevron-left" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="15 6 9 12 15 18" />
                    </svg>
                </button>
                <x-select-input x-model="currMonthYear" name="month_year" x-on:change="currMonthYear = $event.target.value" class="w-full text-xs font-semibold text-gray-600 capitalize">
                    <template x-for="(monthYear,monthIdx) in monthYears" :key="monthIdx">
                        <option x-text="monthYear.label" x-bind:value="monthYear.value" :selected="monthYear.value == currMonthYear"></option>
                    </template>
                </x-select-input>
            </div>

            <div class="flex items-center justify-between pt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <template x-for="day,index in days" :key="index">
                                <th class="p-1.5 bg-gray-100 border border-gray-300 dark:bg-gray-700">
                                    <div class="flex justify-center w-full">
                                        <p x-text="day.substring(0, 2)" class="text-xs font-medium text-center text-gray-800 capitalize dark:text-gray-100"></p>
                                    </div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="week,index in calendarDays[calendarMonthYears[0]]" :key="index">
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
    </div>

    <div class="w-[17rem] shadow-lg">
        <div class="p-5 bg-white border rounded-md dark:bg-gray-700 dark:border-gray-600">
            <div class="flex items-center justify-center w-full gap-8 px-2">
                <p x-text="calendarMonthYears[1]" class="py-2 text-xs font-semibold text-gray-600 capitalize dark:text-gray-300"></p>
            </div>

            <div class="flex items-center justify-between pt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <template x-for="day,index in days" :key="index">
                                <th class="p-1.5 bg-gray-100 border border-gray-300 dark:bg-gray-700">
                                    <div class="flex justify-center w-full">
                                        <p x-text="day.substring(0, 2)" class="text-xs font-medium text-center text-gray-800 capitalize dark:text-gray-100"></p>
                                    </div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="week,index in calendarDays[calendarMonthYears[1]]" :key="index">
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
    </div>

    <div class="w-[17rem] shadow-lg">
        <div class="p-5 bg-white border rounded-md dark:bg-gray-700 dark:border-gray-600">
            <div class="flex items-center justify-between w-full px-2">
                <div class="flex items-center justify-center w-full py-2 ">
                    <p x-text="calendarMonthYears[2].replace('_', '-')" class="text-xs font-semibold text-gray-600 capitalize dark:text-gray-300"></p>
                </div>
                <button type="button" @click="showNextMonth()" title="calendar backward" aria-label="calendar backward" class="text-gray-800 hover:text-gray-400 dark:text-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-chevron-right" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="9 6 15 12 9 18" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center justify-between pt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <template x-for="day,index in days" :key="index">
                                <th class="p-1.5 bg-gray-100 border border-gray-300 dark:bg-gray-700">
                                    <div class="flex justify-center w-full">
                                        <p x-text="day.substring(0, 2)" class="text-xs font-medium text-center text-gray-800 capitalize dark:text-gray-100"></p>
                                    </div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="week,index in calendarDays[calendarMonthYears[2]]" :key="index">
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
    </div>
</div>
@push('custom-scripts')
    <script>
        window.calendar = @json($calendar ?? null);
        window.organizationId = @json(request()->user()->organization_id ?? null);
        window.legends = @json($legends ?? null);
        window.months = @json(array_keys(config('constants.months')));
        window.userId = @json(request()->user()->id ?? null);
    </script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('js/synced.js') }}"></script>
@endpush
