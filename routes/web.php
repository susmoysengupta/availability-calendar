<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DefaultLegendController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LegendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/* ------------------- Public Routes ------------------- */
Route::get('/', fn() => redirect()->route('calendars.index'));

Route::controller(EmbedController::class)
    ->prefix('embed')
    ->as('embed.')
    ->group(function () {
        Route::get('/{calendar}', 'index')->name('index');
        Route::get('/js/{calendar}', 'embedJs')->name('js');
    });

Route::get('invitation/{user}', [UserController::class, 'acceptInvitation'])->name('accept_invitation');
Route::get('calendars/{calendar}/ical', [CalendarController::class, 'downloadICal'])->name('calendars.ical');

/* ------------------- Authenticated Routes ------------------- */
Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::get('set_password', [SetPasswordController::class, 'create'])->name('set_password');
    Route::post('set_password', [SetPasswordController::class, 'store'])->name('set_password.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/user-calendar', [SettingsController::class, 'updateUserCalendar'])->name('update_user_calendar');

    Route::delete('calendars/{calendar}/assigned-editors/{editor}', [CalendarController::class, 'destroyAssignedEditor'])->name('calendars.assigned-editors.destroy');
    Route::post('calendars/{calendar}/assigned-editors/store', [CalendarController::class, 'storeAssignedEditor'])->name('calendars.assigned-editors.store');
    Route::post('calendars/{calendar}/quick-update', [AvailabilityController::class, 'quickUpdate'])->name('calendars.quick-update');
    Route::get('calendars/{calendar}/embed', [CalendarController::class, 'embed'])->name('calendars.embed');
    Route::get('calendars/{calendar}/embed-beta', [CalendarController::class, 'embedBeta'])->name('calendars.embed-beta');
    Route::post('calendars/{calendar}/update-embed-code', [CalendarController::class, 'updateEmbedCode'])->name('calendars.update-embed-code');
    Route::get('calendars/{calendar}/download', [CalendarController::class, 'download'])->name('calendars.download');
    Route::resource('calendars/{calendar}/availability', AvailabilityController::class)->names('calendars.availability');
    Route::resource('calendars/{calendar}/legends', LegendController::class)->names('calendars.legends');

    Route::post('calendars/{calendar}/import-ical', [ImportController::class, 'importICal'])->name('calendars.import-ical');
    Route::delete('calendars/{calendar}/deactivate-syncing', [ImportController::class, 'deactivateSync'])->name('calendars.deactivate-sync');

    Route::resource('calendars', CalendarController::class);

    Route::put('users/update-password/{user}', [UserController::class, 'updatePassword'])->name('users.update_password')
        ->middleware('role:super-admin|super-user|admin');

    Route::resource('users', UserController::class)
        ->middleware('role:super-admin|super-user|admin');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::patch('update-default-timezone', [SettingsController::class, 'updateDefaultTimezone'])->name('update_default_timezone');
        Route::patch('update-language', [SettingsController::class, 'updateLanguage'])->name('update_language');
        Route::delete('destroy-calendar-data', [SettingsController::class, 'destroyCalendarData'])->name('destroy_calendar_data');
        Route::get('/welcome-message', [SettingsController::class, 'welcomeMessage'])->name('welcome_message');
        Route::post('/welcome-message/{organization_id}', [SettingsController::class, 'updateWelcomeMessage'])->name('update_welcome_message');
        Route::resource('default-legends', DefaultLegendController::class)->except(['index', 'show']);

        Route::patch('update-legend-default/{legend}', [LegendController::class, 'updateDefault'])->name('update_legend_default');
        Route::patch('update-legend-visibility/{legend}', [LegendController::class, 'updateVisibility'])->name('update_legend_visibility');
        Route::patch('update-legend-sync/{legend}', [LegendController::class, 'updateSync'])->name('update_legend_sync');
        Route::patch('update-legend-order/{legend}', [LegendController::class, 'updateOrder'])->name('update_legend_order');
    });
});

require __DIR__ . '/auth.php';
