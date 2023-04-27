@if ($paginator->hasPages())
    <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t rounded-b-lg dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <!-- Showing part -->
        <div class="flex items-center col-span-3">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
                {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            {{ $paginator->total() }}
        </div>
        <div class="col-span-2"></div>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <nav aria-label="Table navigation">
                <ul class="inline-flex items-center gap-1">
                    <!-- Previous Page Link -->
                    <li>
                        @if ($paginator->onFirstPage())
                            <button class="px-3 py-1 rounded-md rounded-l-lg dark:text-gray-500 focus:outline-none focus:shadow-outline-purple hover:cursor-not-allowed" aria-label="Previous">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-500 stroke-2">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}" type="button" class="px-3 py-1 mt-1 rounded-md rounded-l-lg dark:text-gray-500 focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-800 stroke-2">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                </svg>

                            </a>
                        @endif
                    </li>

                    <!-- Page links -->
                    @foreach ($elements as $element)
                        <!-- "Three Dots" Separator -->
                        @if (is_string($element))
                            <li>
                                <span class="px-3 py-1">...</span>
                            </li>
                        @endif

                        <!-- Array Of Links -->
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <li>
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page" class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            {{ $page }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    <li>
                        @if ($paginator->hasMorePages())
                            <a href="{{ $paginator->nextPageUrl() }}" type="button" class="px-3 py-1 mt-1 rounded-md rounded-l-lg dark:text-gray-500 focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-800 stroke-2">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <button class="px-3 py-1 rounded-md rounded-l-lg dark:text-gray-500 focus:outline-none focus:shadow-outline-purple hover:cursor-not-allowed" aria-label="{{ __('pagination.next') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-500 stroke-2">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </li>
                </ul>
            </nav>
        </span>
    </div>


@endif
