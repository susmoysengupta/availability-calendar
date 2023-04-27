@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-sm dark:bg-gray-700 dark:border-gray-600 border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 focus-within:text-pruple-600 dark:text-gray-300 form-input']) !!}>
