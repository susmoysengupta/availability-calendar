<section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $heading ?? 'Delete Calednar data' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $subheading ?? 'Delete all calendar data' }}
            </p>
        </div>
    </header>

    <form action="{{ route('settings.destroy_calendar_data') }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('DELETE')
        <div>
            <x-input-label for="period" :value="__('Select Period')" />
            <x-select-input id="period" name="period" class="block w-full mt-1" required>
                @foreach (config('constants.deleteCalendarDataPeriods') as $periodKey => $period)
                    <option value="{{ $periodKey }}" {{ $periodKey == old('period') ? 'selected' : '' }}>
                        {{ $period }}
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('period')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="confirm" :value="__('To confirm the deletion, please type the text of the choice above')" :isRequired="true" />
            <x-text-input id="confirm" name="confirm" class="block w-full mt-1" value="{{ old('confirm') }}" required />
            <x-input-error :messages="$errors->get('confirm')" class="mt-2" />
        </div>

        <!-- BUTTON -->
        <div class="flex items-center gap-4 mt-8">
            <button type="submit" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                <span>{{ __('Delete') }}</span>
            </button>
        </div>
    </form>

</section>
