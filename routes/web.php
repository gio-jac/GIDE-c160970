<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\UserTitleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\StatusController;

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
})->name('index');

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');


Route::get('/dashboard', function () {
    return Inertia::render('apps/invoice/list');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('/users/types', UserTypeController::class);
    Route::resource('/users/titles', UserTitleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/parts', PartController::class);
    Route::post('/parts/excel', [PartController::class, 'storeExcel'])->name('parts.storeExcel');
    Route::resource('/reports/statuses', StatusController::class);
    Route::resource('/reports/codes', CodeController::class);
    Route::get('/reports/{report}/file', [ReportController::class, 'pdfReport'])->name('reports.file');
    Route::resource('/reports', ReportController::class);
    Route::post('/parts/autocomplete', [PartController::class, 'autocomplete'])->name('parts.autocomplete');
});



//Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
