<!-- Title -->
<div>
    <x-input-label for="title" :value="__('Title')" :isRequired="true" />
    <x-text-input type="text" id="title" name="title" value="{{ old('title', $legend->title ?? '') }}" required class="block w-full mt-1" placeholder="Enter Legend Title" autofocus />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<!-- Color & Split Color-->
<div class="flex flex-col w-full gap-6 md:flex-row">
    <div class="w-full">
        <x-input-label for="color" :value="__('Choose Color')" class="mb-1" :isRequired="true" />
        <x-color-picker id="color" name="color" value="{{ old('color', $legend->color ?? '') }}" data-readonly required placeholder="Choose your legend's color" class="block w-full" />
        <x-input-error :messages="$errors->get('color')" class="mt-2" />
    </div>

    @if (!$calendar->is_synced)
        <div class="w-full">
            <x-input-label for="split_color" :value="__('Choose Split Color')" class="mb-1" :isOptional="true" />
            <x-color-picker id="split_color" name="split_color" value="{{ old('split_color', $legend->split_color ?? '') }}" data-readonly placeholder="Choose your legend's split color" class="block w-full" />
            <x-input-error :messages="$errors->get('split_color')" class="mt-2" />
        </div>
    @endif
</div>

<!-- Add to all calendars -->
@if (isset($forCreate) && $forCreate === true)
    <div class="flex items-center">
        <input id="checked-checkbox" name="add_to_all" type="checkbox" value="on" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600">
        <label for="checked-checkbox" class="block ml-2 text-sm text-gray-700 dark:text-gray-300">Add this legend to all calendars</label>
    </div>
@endif

<!-- BUTTONS -->
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
