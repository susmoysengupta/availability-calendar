<x-app-layout>
    <x-slot name="title">
        {{ __('Synced Calendar') }}
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
                {{ __('Synced Calendar') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

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
        </div>
    </div>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        @include('calendars.partials.calendar-grid-synced')

        <hr class="my-5 border-gray-200 dark:border-gray-700">

        @include('calendars.partials.external-calendar-form')
    </div>

    <!-- Assigned Editors -->
    @include('calendars.partials.assigned-editor-form')

    <!-- Embed Calendar -->
    <div class="mb-5 text-gray-700 bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200">
        <a href="{{ route('calendars.embed-beta', $calendar) }}" class="flex w-full p-4 text-sm font-semibold focus:outline-none">Embed Calendar</a>
    </div>
</x-app-layout>
