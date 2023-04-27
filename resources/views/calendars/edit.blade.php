<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Calendar') }}
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
                {{ __('Edit') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    <section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Edit Calendar') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('You can edit your calendar here.') }}
                </p>
            </div>
        </header>
        <form action="{{ route('calendars.update', $calendar) }}" method="POST" class="mt-6 mb-3 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="title" :value="__('Title')" :isRequired="true" />
                <x-text-input type="text" id="title" name="title" value="{{ old('title', $calendar->title ?? '') }}" required class="block w-full mt-1" placeholder="Enter Calendar Title" autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="hyperlink" :value="__('Hyperlink')" />
                <x-text-input type="text" id="hyperlink" name="hyperlink" value="{{ old('hyperlink', $calendar->hyperlink ?? '') }}" class="block w-full mt-1" placeholder="Enter Calendar Hyperlink" />
                <x-input-error :messages="$errors->get('hyperlink')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="image_url" :value="__('Image URL')" />
                <x-text-input type="text" id="image_url" name="image_url" value="{{ old('image_url', $calendar->image_url ?? '') }}" class="block w-full mt-1" placeholder="Enter Calendar Image URL" />
                <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea-input id="description" name="description" class="block w-full mt-1" placeholder="Enter Calendar Description">{{ old('description', $calendar->description ?? '') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <!-- Save Button -->
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

</x-app-layout>
