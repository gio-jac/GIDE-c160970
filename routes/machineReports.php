<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\machine_reports\UserTypeController;
use App\Http\Controllers\machine_reports\UserTitleController;
use App\Http\Controllers\machine_reports\PartController;
use App\Http\Controllers\machine_reports\ReportController;
use App\Http\Controllers\machine_reports\CodeController;
use App\Http\Controllers\machine_reports\StatusController;
use App\Http\Controllers\machine_reports\MachineController;
use App\Http\Controllers\machine_reports\ClientController;
use App\Http\Controllers\machine_reports\BranchController;

Route::middleware('auth')->group(function () {
    Route::resource('/users/types', UserTypeController::class);
    Route::resource('/users/titles', UserTitleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/parts', PartController::class);
    Route::post('/parts/excel', [PartController::class, 'storeExcel'])->name('parts.storeExcel');
    Route::resource('/reports/statuses', StatusController::class);
    Route::resource('/reports/codes', CodeController::class);
    Route::get('/reports/{report}/close',[ReportController::class, 'closeReport'])->name('reports.close');
    Route::get('/reports/{report}/reopen',[ReportController::class, 'reOpenReport'])->name('reports.reopen');
    Route::get('/reports/{report}/{locale}/file', [ReportController::class, 'pdfReport'])->name('reports.file');
    Route::resource('/reports', ReportController::class);
    Route::post('/parts/autocomplete', [PartController::class, 'autocomplete'])->name('parts.autocomplete');
    Route::resource('/machines/clients/branches', BranchController::class);
    Route::resource('/machines/clients', ClientController::class);
    Route::resource('/machines', MachineController::class);
});