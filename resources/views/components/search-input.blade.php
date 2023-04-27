@props(['disabled' => false])

<div class="flex">
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-sm dark:bg-gray-700 dark:border-gray-600 border-gray-300 rounded-l-md rounded-r-none shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 focus-within:text-pruple-600 dark:text-gray-300 form-input']) !!}>
    <button type="submit" class="px-4 py-2 text-xs font-semibold bg-purple-600 border border-transparent rounded-l-none rounded-r-lg text-gray-50 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </button>
</div>
