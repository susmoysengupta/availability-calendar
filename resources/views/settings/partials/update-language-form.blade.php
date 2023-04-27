<section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $heading ?? 'Time Zone' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $subheading ?? 'Update your time zone' }}
            </p>
        </div>
    </header>

    @if ($errors->any())
        <div class="flex p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('settings.update_language') }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')
        <div class="grid grid-cols-5 gap-2">
            @foreach ($languages as $language)
                <div class="flex items-center mb-4">
                    <input id="{{ $language->code }}" name="languages[]" type="checkbox" value="{{ $language->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" @if ($language->code == 'en' || $language->selected) checked @endif @if ($language->code == 'en') onclick="return false;" @endif">
                    <label for="{{ $language->code }}" class="ml-2 text-sm font-medium text-gray-900 truncate dark:text-gray-300 flex gap-1">
                        <img src="{{ asset('vendor/blade-flags/country-' . $language->country_code . '.svg') }}" loading="lazy" class="w-6 h-6" />
                        {{ $language->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <!-- BUTTON -->
        <div class="flex items-center gap-4 mt-8">
            <x-primary-button>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                    </svg>
                </span>
                <span>{{ __('Save') }}</span>
            </x-primary-button>
        </div>
    </form>

</section>
