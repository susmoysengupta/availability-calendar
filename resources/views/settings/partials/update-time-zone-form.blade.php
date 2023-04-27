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

    <form action="{{ route('settings.update_default_timezone') }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')
        <div>
            <x-input-label for="default_timezone" :value="__('Select default timezone')" :isRequired="true" />
            <x-select-input id="default_timezone" name="calendar_timezone" class="block w-full" required>
                @foreach ($timezones as $key => $value)
                    <option value="{{ $key }}" {{ $key == old('calendar_timezone', $organizationTimeZone) ? 'selected' : '' }}>
                        {{ $value }}
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('calendar_timezone')" class="mt-2" />
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
