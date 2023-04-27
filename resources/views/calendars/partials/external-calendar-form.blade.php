<div x-data="externalCalendarForm" class="w-full">
    <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
        <div>
            <h2 class="font-medium text-gray-900 text-md dark:text-gray-100">
                {{ __('External Calendar') }}
            </h2>
        </div>
    </header>

    <!-- Alert if there are errors -->
    @if ($errors->any())
        <div class="flex p-4 mt-2 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <div class="mt-4">
        <!-- Import Form -->
        <form id="import-form" action="{{ route('calendars.import-ical', $calendar) }}" method="POST" @submit="removeEmptyInputs()" class="flex flex-col gap-4">
            @csrf
            <template x-for="(feed,index) in feeds">
                <div>
                    <x-input-label>
                        {{ __('Ical Feed') }}
                        <span x-text="`#${index + 1}`"></span>
                    </x-input-label>
                    <x-text-input x-bind:id="`feed-${index}`" x-bind:value="feed" @change="addOrRemoveFeed($el)" name="feeds[]" class="w-full mt-1" placeholder="Enter external calendar link" />
                    <x-input-error class="mt-2" :messages="$errors->get('feeds')" />
                </div>
            </template>

            <div class="flex flex-col w-full gap-4 md:flex-row md:items-center">
                <!-- Use split days -->
                <div class="w-full">
                    <x-input-label>{{ __('Use split days') }}</x-input-label>
                    <x-select-input name="split" class="w-full mt-1">
                        <option value="0" @if (old('split', $calendar->should_split) == false) selected @endif>No</option>
                        <option value="1" @if (old('split', $calendar->should_split) == true) selected @endif>Yes</option>
                    </x-select-input>
                    <x-input-error for="split" class="mt-2" :messages="$errors->get('split')" />
                </div>

                <!-- Show a day as booked -->
                <div x-show="(feeds.length > 1)" class="w-full">
                    <x-input-label>{{ __('Show a day as booked') }}</x-input-label>
                    <x-select-input name="ical_feed_book_type" class="w-full mt-1">
                        <option value="any" @if (old('ical_feed_book_type', $calendar->ical_feed_book_type) == 'any') selected @endif>
                            If at least one feed has it booked
                        </option>
                        <option value="all" @if (old('ical_feed_book_type', $calendar->ical_feed_book_type) == 'all') selected @endif>
                            If all feeds have it booked
                        </option>
                    </x-select-input>
                    <x-input-error for="ical_feed_book_type" class="mt-2" :messages="$errors->get('ical_feed_book_type')" />
                </div>

                <!-- Change Passed Date Colors -->
                <div>
                    <x-input-label>{{ __('Passed date color') }}</x-input-label>
                    <x-color-picker id="passed_date_color" name="passed_date_color" value="{{ old('passed_date_color', $calendar->passed_date_color ?? '') }}" required />
                    <x-input-error for="passed_date_color" class="mt-2" :messages="$errors->get('passed_date_color')" />
                </div>
            </div>
        </form>

        <!-- Deactivate syncing Form -->
        <form id="deactivate-form" action="{{ route('calendars.deactivate-sync', $calendar) }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <!-- Legends -->
        <div class="flex flex-col gap-2 mt-4">
            @foreach ($legends->take(2) as $legend)
                <div class="flex items-center gap-2">
                    <div class="relative overflow-hidden text-gray-600 rounded w-7 h-7 dark:text-gray-100">
                        @if ($legend->gradient != null)
                            <div class="absolute w-full h-full overflow-hidden clip-left" style="background-color: {{ $legend->color }}"></div>
                            <div class="absolute w-full h-full overflow-hidden clip-right" style="background-color: {{ $legend->split_color }}"></div>
                        @else
                            <div class="absolute w-full h-full overflow-hidden" style="background-color: {{ $legend->color }}"></div>
                        @endif
                    </div>
                    <a href="{{ route('calendars.legends.edit', ['calendar' => $calendar, 'legend' => $legend]) }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400">
                        {{ __($legend->title) }}
                    </a>
                </div>
            @endforeach
        </div>

        {{-- <form action="" method="POST">
            @csrf
            
        </form> --}}

        <!-- Buttons -->
        <div class="flex items-center gap-2 mt-4">
            <x-primary-button form="import-form">
                {{ __('Save/Resync') }}
            </x-primary-button>
            <x-secondary-button type="submit" form="deactivate-form">
                {{ __('Deactivate Syncing') }}
            </x-secondary-button>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('externalCalendarForm', () => ({
                feeds: [],

                init: function() {
                    this.feeds = @json(old('feeds', $iCalFeeds ?? []));
                    this.addFeed();
                },

                addOrRemoveFeed: function(el) {
                    if (el.value) {
                        this.addFeed();
                    } else if (el.value === '' && this.feeds.length > 1) {
                        this.removeFeed(el);
                    }
                },

                addFeed: function() {
                    this.feeds.push('');
                },

                removeFeed: function(el) {
                    let id = el.id.split('-')[1];
                    this.feeds.splice(id, 1);
                },

                removeEmptyInputs: function() {
                    const feedInputs = document.querySelectorAll('input[name="feeds[]"]');
                    feedInputs.forEach((input) => {
                        if (input.value === '') {
                            input.remove();
                        }
                    });
                }
            }));
        });
    </script>
@endpush
