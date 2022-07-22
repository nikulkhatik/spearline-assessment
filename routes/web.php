<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

/* Redirect users to login route if not logged-in */
Route::get('/', function () {
    return view('auth.login');
});

/* Only guest(not logged-in) users can access these routes */
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

/* Only logged-in users can access these routes, authenticated with 'auth' middleware */
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /* Routes for the reports, grouped with prefix 'reports' */
    Route::group(['prefix' => 'reports'], function () {
        Route::get('daily-report', [ReportController::class, 'dailyReport'])
            ->name('reports.dailyReport');

        Route::get('monthly-report', [ReportController::class, 'monthlyReport'])
            ->name('reports.monthlyReport');
    });
});
