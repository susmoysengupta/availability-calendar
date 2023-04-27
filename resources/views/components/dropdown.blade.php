<ul class="flex items-center flex-shrink-0 space-x-6">
    {{ $list }}

    <!-- Profile menu -->
    <li class="relative">
        {{ $trigger }}
        <div x-show="isProfileMenuOpen">
            <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.outside="closeProfileMenu" @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                {{ $content }}
            </ul>
        </div>
    </li>
</ul>
