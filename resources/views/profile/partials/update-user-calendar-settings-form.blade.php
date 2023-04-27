<section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Calendar Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your calendar's settings.") }}
        </p>
    </header>

    <form method="post" action="{{ route('update_user_calendar') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Weeks starts on -->
        <div>
            <x-input-label for="week_start" :value="__('Weeks starts on')" />
            <x-select-input id="week_start" name="week_start" class="block w-full mt-1 capitalize" required>
                @foreach (config('constants.userCalendarSettings.DAYS_ON_WEEK') as $day)
                    <option value="{{ $day }}" {{ old('week_start', $user->week_start) === $day ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('week_start')" />
        </div>

        <!-- Default Ordering -->
        <div>
            <x-input-label for="default_ordering" :value="__('Default ordering')" />
            <x-select-input id="default_ordering" name="default_ordering" class="block w-full mt-1 capitalize" required>
                @foreach (config('constants.userCalendarSettings.ORDERING') as $key => $value)
                    <option value="{{ $key }}" {{ old('default_ordering', $user->default_ordering) === $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('default_ordering')" />
        </div>

        <!-- Calendars Per Page -->
        <div>
            <x-input-label for="per_page" :value="__('Calendars per page')" />
            <x-select-input id="per_page" name="per_page" class="block w-full mt-1 capitalize" required>
                @foreach (config('constants.userCalendarSettings.PER_PAGE') as $order)
                    <option value="{{ $order }}" {{ old('per_page', $user->per_page) === $order ? 'selected' : '' }}>
                        {{ $order }}
                    </option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('per_page')" />
        </div>

        <!-- Show Week Number -->
        <div>
            <x-input-label for="show_week_number" :value="__('Show Week Number')" />
            <x-select-input id="show_week_number" name="show_week_number" class="block w-full mt-1 capitalize" required>
                @foreach (config('constants.userCalendarSettings.SHOW_WEEK_NUMBER') as $key => $value)
                    <option value="{{ $key }}" {{ old('show_week_number', $user->show_week_number) === $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('show_week_number')" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                    </svg>
                </span>
                <span>{{ __('Save') }}</span>

            </x-primary-button>

            @if (session('message') === 'Calendar settings updated successfully')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="font-semibold text-green-600 text-md dark:text-green-400">{{ __(Session::get('message')) }}</p>
            @endif
        </div>
    </form>
</section>
