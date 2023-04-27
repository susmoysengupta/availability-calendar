<x-app-layout>
    <x-slot name="title">
        {{ __('Create Default Legend') }}
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
            <x-breadcrumbs-link href="{{ route('calendars.legends.index', $calendar) }}">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Legends') }}
            </x-breadcrumbs-link>
        </li>
        <li class="flex items-center">
            <x-breadcrumbs-link :isCurrent="true">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Add more legends') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    <section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Create Legend') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('You can create a new legend for your calendar, ') }}
                    <a href="{{ route('calendars.availability.index', $calendar) }}" class="link-underline">
                        {{ __($calendar->title) }}.
                    </a>
                </p>
            </div>
        </header>
        <form action="{{ route('calendars.legends.store', $calendar) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @include('legends.form')
        </form>
    </section>

</x-app-layout>
