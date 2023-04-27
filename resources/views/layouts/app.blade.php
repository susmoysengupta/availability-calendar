<!DOCTYPE html>
<html x-data="data" :class="{ 'dark': dark }" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $title ?? '' }} | {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}" />
    <!-- Scripts -->
    <script src="{{ asset('js/init-alpine.js') }}"></script>
    <script src="{{ asset('js/availability.js') }}"></script>
</head>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white shadow-sm dark:bg-gray-800 md:block">
            <div class="py-4 text-gray-500 dark:text-gray-400">
                @include('layouts.navigation')
            </div>
        </aside>

        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.outside="closeSideMenu"
            @keydown.escape="closeSideMenu">
            <div class="py-4 text-gray-500 dark:text-gray-400">
                @include('layouts.navigation')
            </div>
        </aside>
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.top-menu')
            <main class="h-full overflow-y-auto">
                <div class="container grid px-6 mx-auto">
                    @if (isset($header))
                        <h2 class="flex items-center gap-2 my-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            {{ $header }}
                        </h2>
                    @elseif (isset($breadcrumbs))
                        <nav class="flex px-5 py-3 my-8 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                {{ $breadcrumbs ?? '' }}
                            </ol>
                        </nav>
                    @endif
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @if (Session::has('success'))
        <x-alert type="success"> {{ Session::get('success') }} </x-alert>
    @elseif (Session::has('error'))
        <x-alert type="error"> {{ Session::get('error') }} </x-alert>
    @elseif (Session::has('warning'))
        <x-alert type="warning"> {{ Session::get('warning') }} </x-alert>
    @elseif (Session::has('info'))
        <x-alert type="info"> {{ Session::get('info') }} </x-alert>
    @endif

    @yield('scripts')
    @stack('custom-scripts')
    <script src="{{ asset('js/table-dropdown.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/flowbite.min.js"></script>
</body>

</html>
