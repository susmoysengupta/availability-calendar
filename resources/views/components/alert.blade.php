@props(['type' => 'success'])

@php
    $classes = [
        'success' => [
            'div' => 'border-green-200 dark:border-green-800',
            'text' => 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200',
            'icon' => 'fa-solid fa-check',
        ],
        'error' => [
            'div' => 'border-red-100 dark:border-red-800',
            'text' => 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200',
            'icon' => 'text-lg fa-solid fa-xmark',
        ],
        'warning' => [
            'div' => 'border-orange-100 dark:border-orange-800',
            'text' => 'text-orange-500 bg-orange-100 dark:bg-orange-800 dark:text-orange-200',
            'icon' => 'text-sm fa-solid fa-triangle-exclamation',
        ],
        'info' => [
            'div' => 'border-blue-100 dark:border-blue-800',
            'text' => 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200',
            'icon' => 'fa-solid fa-info',
        ],
    ];
@endphp

<div x-data="{ showAlert: true }" x-show="showAlert" x-init="setTimeout(() => showAlert = false, 5000)" x-transition.duration.300ms class="absolute bottom-0 right-0 z-50 px-8 py-3">
    <div class="{{ $classes[$type]['div'] }} flex items-center w-full max-w-xs gap-3 p-4 mb-4 text-gray-500 bg-white border-t-4 border-x border-b rounded-lg shadow dark:text-gray-400 dark:bg-gray-800">
        <span class="flex items-center justify-center w-8 h-8 rounded-lg {{ $classes[$type]['text'] }}">
            <i class="{{ $classes[$type]['icon'] }}"></i>
        </span>
        <span class="flex-grow text-sm font-normal">{{ $slot }}</span>
        <button @click="showAlert=false" class="flex items-center justify-center w-8 h-8 text-gray-400 bg-white rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
            <i class="text-lg fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
