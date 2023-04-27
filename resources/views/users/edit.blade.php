<x-app-layout>
    <x-slot name="title">{{ __('Edit User') }}</x-slot>
    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <x-breadcrumbs-link href="{{ route('users.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                {{ __('Users') }}
            </x-breadcrumbs-link>
            <x-breadcrumbs-link isCurrent="true">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Edit user') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    <section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Edit User') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('You can edit the user here.') }}
                </p>
            </div>
        </header>
        <form action="{{ route('users.update', $user) }}" method="POST" class="pb-2 mt-6 space-y-6">
            @csrf
            @method('PUT')
            @include('users.form')

            <x-primary-button type="submit">
                {{ __('Save') }}
            </x-primary-button>
        </form>
    </section>

    @include('users.partials.update-password-form', ['user' => $user])
</x-app-layout>
