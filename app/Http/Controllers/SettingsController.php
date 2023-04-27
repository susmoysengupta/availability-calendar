<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCalendarUpdateRequest;
use App\Models\AppSetting;
use App\Models\Availability;
use App\Models\Language;
use App\Models\Legend;
use App\Models\User;
use App\Models\WelcomeMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $timezones = json_decode(Storage::disk('local')->get('timezones.json'), true);
        $organizationTimeZone = User::query()
            ->where('id', request()->user()->organization_id)
            ->first()
            ->calendar_timezone;

        $languages = Language::all();
        $userLanguage = request()->user()->languages()->get();

        // add a key in languages array to check if the language is selected or not
        foreach ($languages as $language) {
            $language->selected = false;
            foreach ($userLanguage as $userLang) {
                if ($language->id == $userLang->id) {
                    $language->selected = true;
                }
            }
        }

        $legends = Legend::query()
            ->global()
            ->where('organization_id', auth()->user()->organization_id)
            ->orderBy('order')
            ->get();

        return view('settings.index', compact(
            'timezones',
            'organizationTimeZone',
            'languages',
            'legends',
        ));
    }

    /**
     * @param  UserCalendarUpdateRequest  $request
     * @return RedirectResponse
     */
    public function updateUserCalendar(UserCalendarUpdateRequest $request): RedirectResponse
    {
        if (!auth()->user()->hasDirectPermission('update-profile')) {
            return Redirect::route('calendars.index');
        }

        $request->user()->update($request->validated());

        return redirect()->back()->with('success', 'Calendar settings updated successfully.');
    }

    /**
     * Update the timezone of the user.
     *
     * @param  string  $timezone
     * @return RedirectResponse
     */
    public function updateDefaultTimezone(Request $request): RedirectResponse
    {
        $request->validate([
            'calendar_timezone' => ['required', 'string', 'max:50', Rule::in(array_keys(json_decode(Storage::disk('local')->get('timezones.json'), true)))],
        ]);
        $user = User::query()->where('id', request()->user()->organization_id)->first();
        $user->update($request->only('calendar_timezone'));

        return redirect()->back()->with('success', 'Default timezone updated successfully.');
    }

    /**
     * Update the language of the user.
     *
     * @param  string  $language
     * @return RedirectResponse
     */
    public function updateLanguage(Request $request): RedirectResponse
    {
        $request->validate([
            'languages' => ['required', 'array'],
            'languages.*' => ['required', 'string'],
        ]);
        $user = User::query()->where('id', request()->user()->organization_id)->first();
        $user->languages()->sync($request->input('languages'));

        return redirect()->back()->with('success', 'Language updated successfully.');
    }

    /**
     * @param Request $request
     */
    public function destroyCalendarData(Request $request): RedirectResponse
    {
        $deleteCalendarDataPeriods = config('constants.deleteCalendarDataPeriods');

        $request->validate([
            'period' => ['required', Rule::in(array_keys($deleteCalendarDataPeriods))],
        ]);

        if ($request->confirm != $deleteCalendarDataPeriods[$request->period]) {
            return redirect()->back()->with('error', 'Confirmation text does not match.')->withInput();
        }

        $calendars = auth()->user()->organization->calendars()->get('id');

        foreach ($calendars as $calendar) {
            Availability::query()
                ->where('calendar_id', $calendar->id)
                ->when($request->period === 'all', fn($query) => $query->where('calendar_id', $calendar->id))
                ->when($request->period === 'past-time', fn($query) => $query->where('start', '<', now()->format('Y-m-d')))
                ->when($request->period === 'year-1', fn($query) => $query->where('start', '<', now()->subYear(2)->format('Y-m-d')))
                ->when($request->period === 'year-2', fn($query) => $query->where('start', '<', now()->subYear(3)->format('Y-m-d')))
                ->delete();
        }

        return redirect()->route('settings.index')->with('success', 'Calendar data deleted successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function welcomeMessage(): View
    {
        $languages = Language::query()
            ->orderByRaw('country_code = "us" DESC')
            ->get();
        $defaultMessage = AppSetting::query()
            ->where('key', 'welcome_message')
            ->firstOrFail()
            ->value;

        $welcomeMessage = auth()->user()
            ->organization
            ->welcomeMessage()
            ->first();

        return view('settings.welcome-message', compact(
            'languages',
            'defaultMessage',
            'welcomeMessage'
        ));
    }

    /**
     * @param User $organization_id
     * @param Request $request
     */
    public function updateWelcomeMessage(User $organization_id, Request $request)
    {
        $languages = Language::all();

        $requestMessageKey = [];
        foreach ($languages as $language) {
            $requestMessageKey[] = $language->code;
        }

        WelcomeMessage::updateOrCreate(
            ['organization_id' => $organization_id->id],
            $request->only($requestMessageKey)
        );

        return redirect()->route('settings.welcome_message')->with('success', 'Welcome message updated successfully.');
    }
}
