@props(['value', 'isOptional' => false, 'isRequired' => false])

<label {{ $attributes->merge(['class' => 'block text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
    @if ($isRequired)
        <span class="text-red-500">*</span>
    @elseif ($isOptional)
        <span class="text-xs text-gray-400">(optional)</span>
    @endif
</label>
