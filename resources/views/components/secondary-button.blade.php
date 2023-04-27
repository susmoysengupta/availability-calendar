<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium leading-5 text-center text-gray-50 bg-purple-600 border border-transparent rounded-lg active:bg-purple-800 hover:bg-purple-800 focus:outline-none focus:ring']) }}>
    {{ $slot }}
</button>
