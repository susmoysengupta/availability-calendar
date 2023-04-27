<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
        <div>
            <h2 class="font-medium text-gray-900 text-md dark:text-gray-100">
                {{ __('Assigned Editors') }}
            </h2>

            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ __('You can assign editors to the calendar') }}
            </p>
        </div>
    </header>
    <div class="mt-6 mb-3 space-y-4">
        <!-- Assigned Editors List -->
        <ul class="w-full space-y-2">
            @forelse ($assignedEditors as $assignedEditor)
                <li>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-500">{{ $assignedEditor->name }}</span>
                        <form action="{{ route('calendars.assigned-editors.destroy', [$calendar, $assignedEditor]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li>
                    <div class="flex items-center justify-center">
                        <span class="text-sm text-gray-600 dark:text-gray-500">{{ __('No editors assigned') }}</span>
                    </div>
                </li>
            @endforelse
        </ul>

        <!-- Assign Editor Form -->
        <form action="{{ route('calendars.assigned-editors.store', $calendar) }}" method="POST" class="mt-2">
            @csrf
            <x-select-input name="editor_id" class="w-full" required>
                <option value="" selected disabled>{{ __('Select an editor') }}</option>
                @foreach ($availableEditors as $availableEditor)
                    <option value="{{ $availableEditor->id }}">{{ $availableEditor->name }}</option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('editor_id')" />
            <x-secondary-button type="submit" class="mt-4 disabled:cursor-not-allowed" :disabled="!$availableEditors->count()">
                {{ __('Assign') }}
            </x-secondary-button>
        </form>
    </div>
</div>
