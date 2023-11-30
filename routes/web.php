<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserTypeController;

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
    return Inertia::render('auth/login');
});

Route::get('/dashboard', function () {
    return Inertia::render('apps/invoice/list');
});

Route::get('/users', function () {
    return Inertia::render('admin/users');
});

Route::get('/users/titles', function () {
    return Inertia::render('admin/catalogs/users/users-titles');
});

Route::resource('/users/types', UserTypeController::class);


//Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
