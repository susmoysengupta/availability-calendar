<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('public/calendars/{calendar}', [AvailabilityController::class, 'getPublicCalendar']);
Route::get('calendars/{calendar}', [AvailabilityController::class, 'getCalendar']);
Route::post('calendars/{calendar}/quick-update', [AvailabilityController::class, 'quickUpdate']);
Route::get('calendars/details/{calendar}', [CalendarController::class, 'getCalendar']);
Route::put('calendars/{calendar}', [CalendarController::class, 'updateCalendar']);
