<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-gray-800 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-600 dark:hover:bg-gray-300 focus:outline-none focus:ring dark:bg-gray-100 dark:text-gray-700']) }}>
    {{ $slot }}
</button>
