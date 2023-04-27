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

    <div x-data="embed_beta" class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
        <section class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800 col-span-2">
            {{-- Toggle Title and Legend --}}
            <header class="mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Toggle Title and Legend') }}
                </h2>

                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    {{ __('Here you can toggle the title and legend of your calendar.') }}
                </p>
            </header>

            <form action="{{ route('calendars.update-embed-code', $calendar) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="title" value="1" class="sr-only peer" @if ($calendar->is_title_visible) checked @endif>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Show Calendar Title</span>
                    </label>
                </div>
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="legend" value="1" class="sr-only peer" @if ($calendar->is_legend_visible) checked @endif>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Show Calendar Legends</span>
                    </label>
                </div>
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
            </form>
        </section>

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
                        <x-textarea-input x-model="codes.script" id="js_code" class="block w-full pr-4 mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
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
                        <x-textarea-input x-model="codes.iframe" id="ifram_code" class="block w-full pr-4 mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
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
                        <x-textarea-input x-model="codes.aTag" id="new_window" class="block w-full pr-4 mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
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
                        <x-textarea-input x-model="codes.popup" id="pop_up" class="block w-full pr-4 mt-1 bg-gray-100 border" rows="5" readonly></x-textarea-input>
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

        <div class="flex items-center justify-center w-full col-span-2">
            <x-primary-button @click="preview">
                Preview
            </x-primary-button>
        </div>

    </div>

    @section('scripts')
        <script>
            window.jsBaseURL = @json(route('embed.js', $calendar));
            window.baseURL = @json(route('embed.index', $calendar));
            window.allMonths = @json(config('constants.months'));
        </script>
        <script src="{{ asset('js/embed-beta.js') }}"></script>
    @endsection
</x-app-layout>
