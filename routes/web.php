<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Cache;
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

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/hello', function () {
    return view('welcome');
});

// Start Google login process
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
// Google callback route
Route::get('auth/google-callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google-callback');

Route::get('/login', function () {
    return view('login');
});

//test redis:
Route::get('/test-redis', function () {
    try {
        Cache::put('test_key', 'test_value', 10);
        $value = Cache::get('test_key');
        return response()->json(['status' => 'success', 'cached_value' => $value]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
});


require __DIR__ . '/auth.php';