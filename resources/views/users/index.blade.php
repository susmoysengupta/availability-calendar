<x-app-layout>
    <x-slot name="title">{{ __('Users') }}</x-slot>
    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <x-breadcrumbs-link isCurrent="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                {{ __('Users') }} ({{ $users->total() }})
            </x-breadcrumbs-link>
        </li>
    </x-slot>

    <!-- Add more and Search form -->
    <div class="grid gap-8 mb-5 lg:flex lg:justify-between lg:flex-wrap">
        <a href="{{ route('users.create') }}" class="text-xs btn btn-secondary"> {{ __('Add New User') }} </a>
        <!-- Search form -->
        <form action="{{ route('users.index') }}" method="GET" class="max-w-md md:max-w-sm">
            <x-search-input name="search" value="{{ old('search', request()->get('search')) }}" placeholder="Search user..." class="w-full" required />
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

    <!-- Users table -->
    <div class="w-full mb-8 border rounded-lg shadow-xs dark:border-gray-600">
        <div class="w-full rounded-t-lg">
            <table class="w-full rounded-t-lg">
                <thead class="rounded-t-lg">
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 rounded-t-lg">Name</th>
                        <th class="px-4 py-3 whitespace-nowrap">Email</th>
                        <th class="px-4 py-3 whitespace-nowrap">Role</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($users as $user)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xs">
                                <a href="{{ route('users.edit', $user) }}" class="font-semibold text-purple-600 dark:text-purple-400">
                                    {{ __($user?->name ?? 'N/A') }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                <span>{{ $user?->email ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                {{ __($user?->roles?->first()?->name ?? 'N/A') }}
                            </td>
                            <td class="px-4 py-3 text-xs text-center text-gray-500 dark:text-gray-400">
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-xs text-center text-gray-500 dark:text-gray-400">
                                <span>No users found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        {{ $users->onEachSide(1)->links() }}
        <p class="text-xs text-gray-500 dark:text-gray-700">

        </p>
    </div>
</x-app-layout>
