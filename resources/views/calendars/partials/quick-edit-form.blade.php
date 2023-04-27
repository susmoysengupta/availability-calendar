<form action="{{ route('calendars.quick-update', $calendar) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    @csrf
    <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
        <div>
            <h2 class="font-medium text-gray-900 text-md dark:text-gray-100">
                {{ __('Quick Edit') }}
            </h2>

            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ __('Quickly edit the calendar') }}
            </p>
        </div>
    </header>
    <div class="mt-6 mb-3 space-y-4">
        <div class="flex items-start w-full gap-2">
            <div class="w-full">
                <x-text-input type="date" name="from" value="{{ old('from', now()->format('Y-m-01')) }}" class="w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('from')" />
            </div>

            <div class="flex items-center h-full py-2.5">
                <span class="text-xs font-semibold text-gray-600 uppercase dark:text-gray-400">to</span>
            </div>

            <div class="w-full">
                <x-text-input type="date" name="to" value="{{ old('to', now()->format('Y-m-d')) }}" class="w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('to')" />
            </div>

        </div>

        <x-select-input name="legend_id" class="w-full">
            @foreach ($legends as $legend)
                <option value="{{ $legend->id }}" @if (old('legend_id') == $legend->id) selected @endif>
                    {{ $legend->title }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error class="mt-2" :messages="$errors->get('legend_id')" />

        <x-text-input name="remarks" value="{{ old('remarks') }}" class="w-full" placeholder="Remarks" />
        <x-input-error class="mt-2" :messages="$errors->get('remarks')" />
    </div>
    <div class="flex items-center gap-2 mt-4">
        <x-secondary-button type="submit">
            {{ __('Apply & Save') }}
        </x-secondary-button>
    </div>
</form>
