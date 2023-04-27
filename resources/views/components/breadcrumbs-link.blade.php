@props(['isCurrent' => false])

<a {{ $isCurrent ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-flex items-center gap-2 text-sm font-medium hover:text-gray-900' . ' ' . ($isCurrent ? 'text-gray-700 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 dark:hover:text-gray-100')]) !!}>
    {{ $slot }}
</a>
