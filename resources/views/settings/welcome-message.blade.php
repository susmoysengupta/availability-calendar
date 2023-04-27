<x-app-layout>
    <x-slot name="title">
        {{ __('Edit User Welcome Message') }}
    </x-slot>
    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <x-breadcrumbs-link href="{{ route('settings.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ __('Settings') }}
            </x-breadcrumbs-link>
        </li>
        <li class="flex items-center">
            <x-breadcrumbs-link :isCurrent="true">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Edit User Welcome Message') }}
            </x-breadcrumbs-link>
        </li>
    </x-slot>
    <section class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <header class="flex flex-col justify-start md:items-center md:justify-between md:flex-row">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ $heading ?? 'Edit Welcome Message' }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $subheading ?? 'You can update your message' }}
                </p>
            </div>
        </header>

        <form x-data="welcome_message" action="{{ route('settings.update_welcome_message', auth()->user()->organization_id) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @foreach ($languages as $language)
                <div class="flex flex-col justify-start gap-8 md:flex-row md:items-start">
                    <div class="flex items-center w-1/3 gap-2 flex-nowrap">
                        <img src="{{ asset('vendor/blade-flags/country-' . $language->country_code . '.svg') }}" loading="lazy" class="w-6 h-6" />
                        <span class="text-gray-600 dark:text-gray-200 whitespace-nowrap">{{ $language->name }}</span>
                    </div>
                    <div id="message-div-{{ $language->code }}" @class([
                        'w-full' => true,
                        'hidden' => !$welcomeMessage || $welcomeMessage[$language->code] === null,
                        'block' => $welcomeMessage && $welcomeMessage[$language->code] !== null,
                    ])>
                        <x-textarea-input id="message-{{ $language->code }}" name="{{ $language->code }}" class="w-full editor" rows="12">{!! $welcomeMessage[$language->code] ?? '' !!}</x-textarea-input>
                        <x-input-error :messages="$errors->get('message_' . $language->code)" class="mt-2" />
                        <div class="flex justify-start gap-4 mt-2">
                            <button type="button" id="btn-remove-{{ $language->code }}" value="{{ $language->code }}" @click="removeTranslation($el)" class="text-sm text-purple-600 dark:text-purple-500">Remove Translation</button>
                            <button type="button" id="btn-reset-{{ $language->code }}" value="{{ $language->code }}" @click="resetTranslation($el)" class="text-sm text-purple-600 dark:text-purple-500">Reset to default</button>
                        </div>
                    </div>
                    <button type="button" id="btn-add-{{ $language->code }}" value="{{ $language->code }}" @click="addTranslation($el)" @class([
                        'w-full text-sm text-left text-purple-600 dark:text-purple-500' => true,
                        'hidden' => $welcomeMessage && $welcomeMessage[$language->code] !== null,
                        'block' => !$welcomeMessage || $welcomeMessage[$language->code] === null,
                    ])>Add Translation</button>
                </div>
                @if ($loop->last === false)
                    <hr class="border-gray-200 dark:border-gray-700" />
                @endif
            @endforeach

            <!-- BUTTON -->
            <div class="pt-4">
                <x-primary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                    </svg>
                    <span>{{ __('Save') }}</span>
                </x-primary-button>
            </div>
        </form>
    </section>
    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

        <script>
            $(document).ready(function() {
                $('.editor').each(function() {
                    CKEDITOR.replace(this, {
                        height: 300,
                        width: '100%',
                        toolbar: [
                            ['Bold', 'Italic', 'Underline', 'Subscript', 'Superscript', '-', 'RemoveFormat'],
                            ['Link', 'Unlink'],
                        ],
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('welcome_message', () => ({
                    addTranslation(el) {
                        const code = el.value;
                        const message = document.getElementById('message-' + code);
                        const messageDiv = document.getElementById('message-div-' + code);
                        const removeButton = document.getElementById('btn-remove-' + code);
                        const resetButton = document.getElementById('btn-reset-' + code);
                        const addButton = document.getElementById('btn-add-' + code);

                        CKEDITOR.instances['message-' + code].setData(@json($defaultMessage));
                        messageDiv.classList.remove('hidden');
                        messageDiv.classList.add('block');
                        addButton.classList.remove('block');
                        addButton.classList.add('hidden');
                    },

                    removeTranslation(el) {
                        const code = el.value;
                        const message = document.getElementById('message-' + code);
                        const messageDiv = document.getElementById('message-div-' + code);
                        const removeButton = document.getElementById('btn-remove-' + code);
                        const resetButton = document.getElementById('btn-reset-' + code);
                        const addButton = document.getElementById('btn-add-' + code);

                        CKEDITOR.instances['message-' + code].setData('');
                        messageDiv.classList.remove('block');
                        messageDiv.classList.add('hidden');
                        addButton.classList.remove('hidden');
                        addButton.classList.add('block');
                    },

                    resetTranslation(el) {
                        const code = el.value;
                        const messageDiv = document.getElementById('message-div-' + code);
                        const message = document.getElementById('message-' + code);
                        const removeButton = document.getElementById('btn-remove-' + code);
                        const resetButton = document.getElementById('btn-reset-' + code);
                        const addButton = document.getElementById('btn-add-' + code);

                        CKEDITOR.instances['message-' + code].setData(@json($defaultMessage));
                    },
                }))
            });
        </script>
    @endsection
</x-app-layout>
