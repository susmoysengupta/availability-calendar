<x-app-layout>
    <x-slot name="title">
        {{ __('Settings') }}
    </x-slot>
    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <x-breadcrumbs-link isCurrent="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ __('Settings') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    @include('settings.partials.update-time-zone-form', [
        'heading' => __('Default Timezone'),
        'subheading' => __('This timezone will be used as default.'),
    ])

    @include('legends.index', [
        'heading' => __('Default legends'),
        'description' => __('These legends will be used as default when creating a new calendar.'),
        'addMoreLink' => route('settings.default-legends.create'),
        'editRoute' => 'settings.default-legends.edit',
        'deleteRoute' => 'settings.default-legends.destroy',
        'canSync' => false,
    ])

    @include('settings.partials.update-language-form', [
        'heading' => __('Language'),
        'subheading' => __('You can add multiple languages from here.'),
    ])

    <section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <a href="{{ route('settings.welcome_message') }}" class="text-sm text-purple-700 dark:text-purple-600">
            {{ __('Edit User Welcome Message') }}
        </a>
    </section>

    @include('settings.partials.delete-calendar-data-form', [
        'heading' => __('Delete Calendar Data'),
        'subheading' => __('This will delete the availability and booking notes of all calendars.'),
    ])
</x-app-layout>
