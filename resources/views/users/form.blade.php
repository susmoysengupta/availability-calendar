<div class="flex flex-col w-full gap-2 md:flex-row">
    <!-- Name -->
    <div class="w-full">
        <x-input-label for="name" :value="__('Full Name')" :isRequired="true" />
        <x-text-input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required class="block w-full mt-1" placeholder="Enter Full Name" autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="w-full">
        <x-input-label for="email" :value="__('Email')" :isRequired="true" />
        <x-text-input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="block w-full mt-1" placeholder="Enter Email" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>

<div class="flex flex-col w-full gap-2 md:flex-row">
    <!-- Language -->
    <div class="w-full">
        <x-input-label for="language_id" :value="__('Language')" />
        <x-select-input id="language_id" name="language_id" class="block w-full mt-1 capitalize" required>
            @foreach ($languages as $id => $name)
                <option value="{{ $id }}" {{ old('language_id', $user->language_id ?? '') === $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('language_id')" class="mt-2" />
    </div>

    <!-- Role -->
    <div class="w-full">
        <x-input-label for="role_id" :value="__('Role')" />
        <x-select-input id="role_id" name="role_id" class="block w-full mt-1 capitalize" required>
            @foreach ($roles as $id => $name)
                <option value="{{ $id }}" {{ old('role_id', $userRole ?? -1) === $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
    </div>
</div>

<div class="flex flex-col w-full gap-2 md:flex-row">
    @php
        $canUpdateProfile = isset($user) ? $user->hasDirectPermission('update-profile') : -1;
        $canUpdateLegend = isset($user) ? $user->hasDirectPermission('update-legend') : -1;
    @endphp
    <!-- Can edit profile -->
    <div class="w-full">
        <x-input-label for="can_update_profile" :value="__('Can edit profile')" />
        <x-select-input id="can_update_profile" name="can_update_profile" class="block w-full mt-1 capitalize" required>
            <option value="1" {{ old('can_update_profile', $canUpdateProfile) === true ? 'selected' : '' }}>
                Yes
            </option>
            <option value="0" {{ old('can_update_profile', $canUpdateProfile) === false ? 'selected' : '' }}>
                No
            </option>
        </x-select-input>
        <x-input-error :messages="$errors->get('can_update_profile')" class="mt-2" />
    </div>

    <!-- Can edit legend -->
    <div class="w-full">
        <x-input-label for="can_update_legend" :value="__('Can edit legend')" />
        <x-select-input id="can_update_legend" name="can_update_legend" class="block w-full mt-1 capitalize" required>
            <option value="1" {{ old('can_update_legend', $canUpdateLegend) === true ? 'selected' : '' }}>
                Yes
            </option>
            <option value="0" {{ old('can_update_legend', $canUpdateLegend) === false ? 'selected' : '' }}>
                No
            </option>
        </x-select-input>
        <x-input-error :messages="$errors->get('can_update_legend')" class="mt-2" />
    </div>
</div>

<div class="flex flex-col w-full gap-2 md:flex-row">
    <!-- Weeks starts on -->
    <div class="w-full">
        <x-input-label for="week_start" :value="__('Weeks starts on')" />
        <x-select-input id="week_start" name="week_start" class="block w-full mt-1 capitalize" required>
            @foreach (config('constants.userCalendarSettings.DAYS_ON_WEEK') as $day)
                <option value="{{ $day }}" {{ old('week_start', $user->week_start ?? '') === $day ? 'selected' : '' }}>
                    {{ $day }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error class="mt-2" :messages="$errors->get('week_start')" />
    </div>

    <!-- Show Week Number -->
    <div class="w-full">
        <x-input-label for="show_week_number" :value="__('Show Week Number')" />
        <x-select-input id="show_week_number" name="show_week_number" class="block w-full mt-1 capitalize" required>
            @foreach (config('constants.userCalendarSettings.SHOW_WEEK_NUMBER') as $key => $value)
                <option value="{{ $key }}" {{ old('show_week_number', $user->show_week_number ?? -1) === $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error class="mt-2" :messages="$errors->get('show_week_number')" />
    </div>
</div>

<div class="flex flex-col w-full gap-2 md:flex-row">
    <!-- Default Ordering -->
    <div class="w-full">
        <x-input-label for="default_ordering" :value="__('Default ordering')" />
        <x-select-input id="default_ordering" name="default_ordering" class="block w-full mt-1 capitalize" required>
            @foreach (config('constants.userCalendarSettings.ORDERING') as $key => $value)
                <option value="{{ $key }}" {{ old('default_ordering', $user->default_ordering ?? -1) === $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error class="mt-2" :messages="$errors->get('default_ordering')" />
    </div>

    <!-- Calendars Per Page -->
    <div class="w-full">
        <x-input-label for="per_page" :value="__('Calendars per page')" />
        <x-select-input id="per_page" name="per_page" class="block w-full mt-1 capitalize" required>
            @foreach (config('constants.userCalendarSettings.PER_PAGE') as $order)
                <option value="{{ $order }}" {{ old('per_page', $user->per_page ?? -1) === $order ? 'selected' : '' }}>
                    {{ $order }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error class="mt-2" :messages="$errors->get('per_page')" />
    </div>
</div>

<div class="w-full">
    <x-input-label for="calendars" :value="__('Assigned Calendars')" />
    <x-select-input id="calendars" name="calendars[]" class="block w-full mt-1 capitalize" multiple="multiple">
        @foreach ($calendars as $id => $title)
            <option value="{{ $id }}" @isset($user)
                @if (in_array($id, $user->assignedCalendars->pluck('id')->toArray()))
                    selected
                @endif
            @endisset>
                {{ $title }}
            </option>
        @endforeach
    </x-select-input>
    <x-input-error class="mt-2" :messages="$errors->get('calendars')" />
</div>
