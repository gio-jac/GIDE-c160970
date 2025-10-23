<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return $user->user_type_id == 1
            ? redirect()->route('users.index')
            : redirect()->route('service-visit.index');
    }

    return Inertia::render('auth/login');
})->name('index');

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/heartbeat', function () {
        // This will reset the session timeout
        return;
    });
});



//Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
