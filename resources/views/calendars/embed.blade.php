<x-app-layout>
    <x-slot name="title">
        {{ __('Embed') }}
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
                {{ __('Embed') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    <div class="flex items-center justify-between mb-8">
        <div class="flex-1 min-w-0">
            <a href="{{ route('calendars.availability.index', $calendar) }}" class="text-xl font-bold leading-7 text-gray-700 sm:truncate sm:text-2xl sm:tracking-tight dark:text-gray-100 link hover:text-gray-600 dark:hover:text-gray-200">{{ __($calendar->title) }}</a>
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
        <div class="flex mt-5 lg:mt-0 lg:ml-4">
            <span class="block">
                <a href="{{ route('calendars.edit', $calendar) }}" type="button" class="btn btn-secondary">
                    <!-- Heroicon name: mini/pencil -->
                    <svg class="w-5 h-5 sm:mr-2 sm:-ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                    </svg>
                    <span class="hidden sm:block">Edit</span>
                </a>
            </span>
        </div>
    </div>

    <div x-data="embed" class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
        <section class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <header class="mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Preview Options') }}
                </h2>

                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    {{ __("Here you can play around with your calendar's preview options.") }}
                </p>
            </header>
            <div class="mt-6 mb-2 space-y-6">
                <div>
                    <x-input-label for="view" :value="__('View')" class="font-semibold" />
                    <x-select-input id="view" x-model="view" class="block w-full mt-1 capitalize">
                        <option value="monthly">{{ __('Monthly') }}</option>
                        <option value="yearly">{{ __('Yearly') }}</option>
                        <option value="multiple">{{ __('Multiple Calendars') }}</option>
                    </x-select-input>
                </div>
                <div x-show="isShowingMonthly">
                    <x-input-label for="calendar_title" :value="__('Display Calendar Title')" class="font-semibold" />
                    <x-select-input id="calendar_title" x-model="previewOptions.title" class="block w-full mt-1">
                        <option value="no">{{ __('No') }}</option>
                        <option value="yes">{{ __('Yes') }}</option>
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="booking_information" :value="__('Display booking information')" class="font-semibold" />
                    <x-select-input id="booking_information" x-model="previewOptions.bookingInfo" class="block w-full mt-1">
                        <option value="no">{{ __('No') }}</option>
                        <option value="yes">{{ __('Yes') }}</option>
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="language" :value="__('Language')" class="font-semibold" />
                    <x-select-input id="language" x-model="previewOptions.lang" class="block w-full mt-1">
                        <option value="en">{{ __('English') }}</option>
                    </x-select-input>
                </div>
                <div x-show="isShowingMonthly">
                    <x-input-label for="number_of_months" :value="__('Number of months to show')" class="font-semibold" />
                    <x-select-input id="number_of_months" x-model="previewOptions.noOfMonths" class="block w-full mt-1">
                        @foreach (range(1, 12) as $number)
                            <option value="{{ $number }}">{{ $number }}</option>
                        @endforeach
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="display_legend" :value="__('Display legend')" class="font-semibold" />
                    <x-select-input id="display_legend" x-model="previewOptions.show_legend" class="block w-full mt-1">
                        <option value="no">{{ __('No') }}</option>
                        <option value="top">{{ __('Yes, on top') }}</option>
                        <option value="bottom">{{ __('Yes, at the end') }}</option>
                    </x-select-input>
                </div>

                <div x-show="(isShowingMonthly || isShowingMultiple)">
                    <x-input-label for="week_number" :value="__('Display week numbers')" class="font-semibold" />
                    <x-select-input id="week_number" x-model="previewOptions.weekNumber" class="block w-full mt-1">
                        <option value="no">{{ __('No') }}</option>
                        <option value="us">{{ __('Yes, US') }}</option>
                        <option value="iso">{{ __('Yes, standard ISO (Europe)') }}</option>
                    </x-select-input>
                </div>
                <div x-show="isShowingMonthly">
                    <x-input-label for="first_day" :value="__('First day of the week')" class="font-semibold" />
                    <x-select-input id="first_day" x-model="previewOptions.firstDay" class="block w-full mt-1 capitalize">
                        @foreach (config('constants.days') as $key => $day)
                            <option value="{{ $key }}">{{ $day }}</option>
                        @endforeach
                    </x-select-input>
                </div>
                <div x-show="isShowingMonthly">
                    <x-input-label for="start_date" :value="__('Start date')" class="font-semibold" />
                    <x-select-input id="start_date" x-model="previewOptions.startDate" class="block w-full mt-1">
                        <option value="current">{{ __('Current Date') }}</option>
                        <option value="january-2023">{{ __('January 2023') }}</option>
                        <option value="february-2023">{{ __('February 2024') }}</option>
                    </x-select-input>
                </div>

                <div x-show="isShowingYearly">
                    <x-input-label for="start_year" :value="__('Start year')" class="font-semibold" />
                    <x-select-input id="start_year" class="block w-full mt-1">
                        <option value="current">{{ __('Current Date') }}</option>
                        <option value="2022">{{ __('2022') }}</option>
                        <option value="2023">{{ __('2023') }}</option>
                    </x-select-input>
                </div>

                <div>
                    <x-input-label for="display_history" :value="__('Display History')" class="font-semibold" />
                    <x-select-input id="display_history" x-model="previewOptions.history" class="block w-full mt-1">
                        <option value="yes">{{ __('Show booking history') }}</option>
                        <option value="default">{{ __('Replace history with the default legend item') }}</option>
                        <option value="gray">{{ __('Gray out history') }}</option>
                    </x-select-input>
                </div>
                <div>
                    <x-primary-button x-on:click="preview()" class="w-full mt-4">
                        {{ __('Preview') }}
                    </x-primary-button>
                </div>
        </section>

        <div class="grid grid-cols-1 gap-6">
            <!-- Embed Code -->
            <section class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Embed Code') }}
                    </h2>

                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                        {{ __("Here you can see your calendar's embed code.") }}
                    </p>
                </header>
                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="js_code" :value="__('Copy the JavaScript below and paste it into your website:')" />
                        <div class="relative">
                            <x-textarea-input x-model="codes.script" id="js_code" class="block w-full mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
                            <button title="Copy to clipboard" @click="copyToClipboard(codes.script)" class="absolute top-0 right-0 mt-2 mr-2 text-sm text-gray-500 focus:outline-none" id="copy-js-code">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="ifram_code" :value="__('Or, if you can’t use JavaScript, you can use this iframe code:')" />
                        <div class="relative">
                            <x-textarea-input x-model="codes.iframe" id="ifram_code" class="block w-full mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
                            <button title="Copy to clipboard" @click="copyToClipboard(codes.iframe)" class="absolute top-0 right-0 mt-2 mr-2 text-sm text-gray-500 focus:outline-none" id="copy-ifram-code">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>

                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Hyperlink / Pop-up Code -->
            <section class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Hyperlink / Pop-up Code') }}
                    </h2>

                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                        {{ __("Here you can see your calendar's hyperlink / pop-up code.") }}
                    </p>
                </header>
                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="direct_link" :value="__('A direct link to the calendar:')" />
                        <div class="relative">
                            <x-textarea-input x-model="codes.directLink" id="direct_link" class="block w-full p-1 mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
                            <button title="Copy to clipboard" @click="copyToClipboard(codes.directLink)" class="absolute top-0 right-0 mt-2 mr-2 text-sm text-gray-500 focus:outline-none" id="copy-direct-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="new_window" :value="__('HTML code that opens the calendar in a new window:')" />
                        <div class="relative">
                            <x-textarea-input x-model="codes.aTag" id="new_window" class="block w-full mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
                            <button title="Copy to clipboard" @click="copyToClipboard(codes.aTag)" class="absolute top-0 right-0 mt-2 mr-2 text-sm text-gray-500 focus:outline-none" id="copy-new-window-code">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>

                            </button>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="pop_up" :value="__('HTML code that opens the calendar in a pop-up:')" />
                        <div class="relative">
                            <x-textarea-input x-model="codes.popup" id="pop_up" class="block w-full mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
                            <button title="Copy to clipboard" @click="copyToClipboard(codes.popup)" class="absolute top-0 right-0 mt-2 mr-2 text-sm text-gray-500 focus:outline-none" id="copy-popup-code">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>

                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @section('scripts')
        <script>
            window.jsBaseURL = @json(route('embed.js', $calendar));
            window.baseURL = @json(route('embed.index', $calendar));
            window.allMonths = @json(config('constants.months'));
        </script>
        <script src="{{ asset('js/embed.js') }}"></script>
    @endsection
</x-app-layout>
