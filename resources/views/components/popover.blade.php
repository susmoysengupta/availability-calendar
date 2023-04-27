@props(['id', 'placement' => 'top', 'title' => '', 'popoverTitle' => '', 'popoverContent' => 'Popover content', 'popoverFooter' => ''])
<div class="flex items-center justify-center">
    {{ $title }}
    <button data-popover-target="{{ $id }}" data-popover-placement="top" type="button">
        <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Show information</span>
    </button>
</div>
<div data-popover id="{{ $id }}" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
    <div class="p-3 space-y-2">
        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $popoverTitle }}</h3>
        <p class="text-sm leading-normal normal-case">
            {{ $popoverContent }}
        </p>
    </div>
    <div data-popper-arrow></div>
</div>
