<x-app-layout>
    <x-slot name="title">
        {{ __('Calendars') }}
    </x-slot>
    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <x-breadcrumbs-link href="{{ route('calendars.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                {{ __('Calenders') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    <!-- Create and Search form -->
    <div class="grid gap-8 mb-5 lg:flex lg:justify-between lg:flex-wrap">
        <form action="{{ route('calendars.store') }}" method="POST" class="max-w-md md:max-w-sm">
            @csrf
            <div class="grid w-full gap-3 sm:flex sm:flex-wrap">
                <x-text-input name="title" value="{{ old('title') }}" placeholder="Enter Calendar Name" required />
                <x-secondary-button type="submit" class="text-xs "> {{ __('Create Calendar') }} </x-secondary-button>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
        </form>
        <!-- Search form -->
        <form action="{{ route('calendars.index') }}" method="GET" class="max-w-md md:max-w-sm">
            <x-search-input name="search" value="{{ old('search', request()->get('search')) }}" placeholder="Search calender..." class="w-full" required />
            @if (request()->has('search'))
                <p class="mt-1 text-xs text-gray-500">
                    Showing results for <span class="font-semibold"> {{ request()->get('search') }} </span>
                    <a href="{{ route('calendars.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </p>
            @endif
        </form>
    </div>

    <!-- Calendars table -->
    <div x-data="modal" class="w-full mb-8 border rounded-lg shadow-xs dark:border-gray-600">
        <div class="w-full rounded-t-lg">
            <table class="w-full rounded-t-lg">
                <thead class="rounded-t-lg">
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 rounded-t-lg">Title</th>
                        <th class="px-4 py-3 text-right whitespace-nowrap">Created at</th>
                        <th class="hidden px-4 py-3 text-center lg:block">Updated at</th>
                        <th class="px-4 py-3 text-center rounded-t-lg"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($calendars as $calendar)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xs">
                                <a href="{{ route('calendars.availability.index', $calendar->id) }}" class="font-semibold text-purple-600 dark:text-purple-500"> {{ __($calendar->title) }} </a>
                            </td>
                            <td class="px-4 py-3 text-xs text-right text-gray-500 dark:text-gray-400">
                                <span>{{ $calendar->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="hidden px-4 py-3 text-xs text-center text-gray-500 md:block dark:text-gray-400">
                                <span>{{ $calendar->updated_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <div class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
                                    <!-- CALENDAR TABLE DROPDOWN STARTS -->
                                    <div class="relative">
                                        <button class="flex items-center gap-2 text-xs font-semibold text-purple-600 align-middle dark:text-purple-300 focus:outline-none calendar-table-dropdown-btn">
                                            <span class="hidden md:block">Options</span>
                                            <span class="hidden md:block">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </span>
                                            <span class="md:hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
                                            </span>
                                        </button>

                                        <ul class="absolute right-0 z-10 hidden w-40 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700 calendar-table-dropdown">
                                            <li class="flex">
                                                <a href="{{ route('calendars.availability.index', $calendar->id) }}" class="flex items-center w-full gap-3 px-2 py-1 text-xs font-semibold text-purple-600 transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-purple-800 dark:hover:bg-gray-800 dark:text-purple-400 dark:hover:text-purple-500" href="./edit-calendar.html">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                                    </svg>
                                                    <span>Set Availability</span>
                                                </a>
                                            </li>
                                            <hr class="border-gray-200 dark:border-gray-600" />
                                            <li class="flex">
                                                <a href="{{ route('calendars.edit', $calendar->id) }}" class="flex items-center w-full gap-3 px-2 py-1 text-xs font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="./edit-calendar-name-settings.html">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    <span>Edit</span>
                                                </a>
                                            </li>
                                            <li class="flex">
                                                <a data-modal-target="export-{{ $calendar->id }}" data-modal-show="export-{{ $calendar->id }}" class="flex items-center w-full gap-3 px-2 py-1 text-xs font-semibold transition-colors duration-150 rounded-md cursor-pointer hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                                                    </svg>
                                                    <span>Export</span>
                                                </a>
                                            </li>
                                            @if ($calendar->is_synced == false)
                                                <li class="flex">
                                                    <button id="sync-{{ $calendar->id }}" type="button" @click="setSyncLink($el, @json($calendar->id))" value="{{ route('calendars.ical', $calendar) }}" class="flex items-center w-full gap-3 px-2 py-1 text-xs font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" data-modal-target="sync-modal" data-modal-toggle="sync-modal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                        </svg>
                                                        <span>Sync</span>
                                                    </button>
                                                </li>
                                            @endif
                                            <li class="flex">
                                                <a href="{{ route('calendars.embed-beta', $calendar) }}" class="flex items-center w-full gap-3 px-2 py-1 text-xs font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="./embed-calendar.html">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                                    </svg>
                                                    <span>Embed</span>
                                                </a>
                                            </li>
                                            <hr class="border-gray-200 dark:border-gray-600" />
                                            @hasanyrole('super-admin|super-user|admin')
                                                <li class="flex">
                                                    <form action="{{ route('calendars.destroy', $calendar) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this calendar?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex items-center w-full gap-3 px-2 py-1 text-xs font-semibold text-red-500 transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-red-600 dark:hover:bg-gray-800 dark:hover:text-red-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endhasanyrole
                                        </ul>
                                    </div>
                                    <!-- CALENDAR TABLE DROPDOWN ENDS -->
                                </div>
                            </td>
                        </tr>
                        @include('calendars.partials.export-modal', ['id' => $calendar->id, 'title' => $calendar->title, 'route' => route('calendars.download', $calendar)])

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                                No calendars found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        {{ $calendars->onEachSide(1)->links() }}

        <!-- modal -->
        <div id="sync-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-md md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="sync-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium leading-loose text-gray-900 dark:text-white">Sync this calendar</h3>
                        <div class="flex mt-4">
                            <x-text-input x-model="syncLink" type="text" readonly id="website-admin" class="w-full border-r-0 rounded-r-none" placeholder="elonmusk" />
                            <button @click="copyToClipboard()" class="inline-flex items-center px-3 text-sm text-gray-800 border border-l-0 border-gray-300 rounded-r-md dark:text-gray-400 dark:border-gray-600">
                                <svg x-show="showCopyIcon" class="w-4 h-4" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5 22q-.825 0-1.413-.587Q3 20.825 3 20V6h2v14h11v2Zm4-4q-.825 0-1.412-.587Q7 16.825 7 16V4q0-.825.588-1.413Q8.175 2 9 2h9q.825 0 1.413.587Q20 3.175 20 4v12q0 .825-.587 1.413Q18.825 18 18 18Zm0-2h9V4H9v12Zm0 0V4v12Z" />
                                </svg>
                                <svg x-show="!showCopyIcon" class="w-4 h-4 text-green-500" viewBox="0 0 16 16">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.75 8.75l3.5 3.5l7-7.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center mt-4">
                            <input x-model="isBookingDetailsChecked" @change="updateCalendar()" id="checked-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checked-checkbox" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Include Booking Details in feed?
                            </label>
                        </div>

                        <div x-show="isSuccessMessageShowing" x-text="successMessage" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-gray-800 dark:text-green-400 mt-4" role="alert">
                        </div>
                        <div x-show="isErrorMessageShowing" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-gray-800 dark:text-red-400" role="alert">
                            Something went wrong. Please try again.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('modal', () => ({
                    sync: "",
                    syncLink: "",
                    showCopyIcon: true,
                    isBookingDetailsChecked: false,
                    calendarId: -1,
                    isSuccessMessageShowing: false,
                    isErrorMessageShowing: false,
                    successMessage: "",

                    setSyncLink: function(el, calendarId) {
                        this.calendarId = calendarId;
                        this.getBookingDetails(calendarId);
                        this.syncLink = el.value;
                    },

                    copyToClipboard: function() {
                        if (!this.syncLink) return;
                        const el = document.createElement("textarea");
                        el.value = this.syncLink;
                        document.body.appendChild(el);
                        el.select();
                        document.execCommand("copy");
                        document.body.removeChild(el);

                        this.showCopyIcon = false;
                        setTimeout(() => {
                            this.showCopyIcon = true;
                        }, 5000);
                    },

                    getBookingDetails: function(calendarId) {
                        axios.get('/api/calendars/details/' + calendarId)
                            .then((response) => {
                                this.isBookingDetailsChecked = response.data.should_include_details;
                            })
                            .catch((error) => {
                                this.showErrorMessage();
                                console.log(error);
                            })
                    },

                    updateCalendar: function() {
                        axios.put('/api/calendars/' + this.calendarId, {
                                should_include_details: this.isBookingDetailsChecked
                            })
                            .then((response) => {
                                if (response.data.should_include_details) {
                                    this.successMessage = "Booking details are added to the iCal feed!";
                                } else {
                                    this.successMessage = "Booking details are removed from the iCal feed!";
                                }
                                this.showSuccessMessage();
                            })
                            .catch((error) => {
                                this.showErrorMessage();
                                console.log(error);
                            });
                    },

                    showSuccessMessage: function() {
                        this.isSuccessMessageShowing = true;
                        setTimeout(() => {
                            this.isSuccessMessageShowing = false;
                            this.successMessage = "";
                        }, 3000);
                    },

                    showErrorMessage: function() {
                        this.isErrorMessageShowing = true;
                        setTimeout(() => {
                            this.isErrorMessageShowing = false;
                        }, 3000);
                    },
                }))
            })
        </script>
    @endsection

</x-app-layout>
