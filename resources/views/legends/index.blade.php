<section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $heading ?? 'Legends' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {!! $description ?? 'Showing all legends' !!}
            </p>
        </div>

        <div class="flex items-center justify-start">
            <a href="{{ $addMoreLink }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>{{ __('Add more') }}</span>
            </a>
        </div>
    </header>

    <div class="w-full mt-6 mb-3 space-y-6 border rounded-lg shadow-xs dark:border-gray-600">
        <div class="w-full overflow-x-auto rounded-lg">
            <table class="w-full whitespace-no-wrap rounded-lg">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 text-left ">Color & Title</th>
                        <th class="px-4 py-3 text-center">Default</th>
                        <th class="px-4 py-3 text-center">
                            <x-popover id="popover-visible" placement="top" title="Visible" popoverTitle="What is Visible?" popoverContent="Enabled items will be displayed in the legend when you embed or share your calendar. If you don't want a legend item to display in the legend, you can disable it here." />
                        </th>
                        @if ($canSync)
                            <th class="px-4 py-3 text-center ">
                                <x-popover id="popover-sync" placement="top" title="Sync as Booked" popoverTitle="What is Sync as Booked?" popoverContent="Enabled items will be synced to other sites. You may not want to sync your 'splitted' legend items. Because sites like Airbnb will block that days completely in their calendar." />
                            </th>
                        @endif
                        <th class="px-4 py-3 text-center ">Ordering</th>
                        <th class="px-4 py-3 text-center ">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($legends as $legend)
                        <tr class="text-sm text-gray-700 dark:text-gray-400">
                            <!-- Color & Title -->
                            <td class="px-4 py-3 text-left ">
                                <div class="flex items-center text-sm">
                                    <div class="relative w-5 h-5 mr-3 overflow-hidden rounded md:w-8 md:h-8 md:block">
                                        @if ($legend->split_color != null)
                                            <div class="absolute w-full h-full overflow-hidden clip-left" style="background-color: {{ $legend->color }}"></div>
                                            <div class="absolute w-full h-full overflow-hidden clip-right" style="background-color: {{ $legend->split_color }}"></div>
                                        @else
                                            <div class="absolute w-full h-full overflow-hidden" style="background-color: {{ $legend->color }}"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ __($legend->title) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ implode(', ', [$legend->color, $legend->split_color]) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <!-- Default -->
                            <td class="flex items-center justify-center px-4 py-3">
                                @if (!$legend->is_default)
                                    <form action="{{ route('settings.update_legend_default', $legend) }}" method="POST" class="flex justify-center" title="Click to mark this legend as default">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_default" value="1">
                                        <input type="hidden" name="id" value="{{ $legend->id }}">
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 fill-gray-300 dark:fill-gray-700 dark:text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-orange-500 fill-orange-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            <!-- Visible -->
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('settings.update_legend_visibility', $legend) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Click to make it hidden">
                                        @if ($legend->is_visible)
                                            <span class="flex w-4 h-4 bg-green-600 rounded-full"></span>
                                        @else
                                            <span class="flex w-4 h-4 bg-gray-300 rounded-full dark:bg-gray-700"></span>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <!-- Sync -->
                            @if ($canSync)
                                <td class="px-4 py-3 text-center ">
                                    <form action="{{ route('settings.update_legend_sync', $legend) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" title="Click to make it unsynced">
                                            @if ($legend->is_synced)
                                                <span class="flex w-4 h-4 bg-green-600 rounded-full"></span>
                                            @else
                                                <span class="flex w-4 h-4 bg-gray-300 rounded-full dark:bg-gray-700"></span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            @endif

                            <!-- Ordering -->
                            <td class="flex items-center justify-center gap-2 px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                @if ($loop->first == false)
                                    <form action="{{ route('settings.update_legend_order', $legend) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="order" value="{{ $legend->order - 1 }}">
                                        <button type="submit" name="move_up_btn" title="Click to move up">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                @if ($loop->last == false)
                                    <form action="{{ route('settings.update_legend_order', $legend) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="order" value="{{ $legend->order + 1 }}">
                                        <button type="submit" name="move_down_btn" title="Click to move down">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center space-x-4 text-sm">
                                    <a href="{{ isset($editRoute) ? route($editRoute, array_merge($routeKey ?? [], [$legend])) : '#' }}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    @if (!$legend->is_default)
                                        <form action="{{ isset($deleteRoute) ? route($deleteRoute, array_merge($routeKey ?? [], [$legend])) : '#' }}" method="POST" onsubmit="return confirm('Do you really want to delete this legend?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ __('No legends found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
