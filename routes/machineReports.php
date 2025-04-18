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
use App\Http\Controllers\machine_reports\BranchManagerController;
use App\Http\Controllers\machine_reports\FailureController;
use App\Http\Controllers\machine_reports\FailureTypeController;
use App\Http\Controllers\machine_reports\ModuleController;

Route::middleware('auth')->group(function () {
    // User routes
    Route::resource('/users/types', UserTypeController::class);
    Route::resource('/users/titles', UserTitleController::class);
    Route::resource('/users', UserController::class);

    // Part routes
    Route::get('/parts/export', [PartController::class, 'exportExcel'])->name('parts.exportExcel');
    Route::post('/parts/excel', [PartController::class, 'storeExcel'])->name('parts.storeExcel');
    Route::post('/parts/autocomplete', [PartController::class, 'autocomplete'])->name('parts.autocomplete');
    Route::resource('/parts', PartController::class);

    // Report routes
    Route::resource('/reports/causes', FailureController::class);
    Route::resource('/reports/solutions', FailureTypeController::class);
    Route::resource('/reports/errors', ModuleController::class);
    Route::resource('/reports/statuses', StatusController::class);
    Route::resource('/reports/codes', CodeController::class);
    Route::get('/reports/{report}/close', [ReportController::class, 'closeReport'])->name('reports.close');
    Route::get('/reports/{report}/reopen', [ReportController::class, 'reOpenReport'])->name('reports.reopen');
    Route::get('/reports/{report}/{locale}/file', [ReportController::class, 'pdfReport'])->name('reports.file');
    Route::get('/reports/export', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    Route::get('/reports/filterByDate', [ReportController::class, 'filterReports'])->name('reports.filterByDate');
    Route::resource('/reports', ReportController::class);

    // Machine routes
    Route::post('/machines/autocomplete', [MachineController::class, 'autocomplete'])->name('machines.autocomplete');
    Route::get('/machines/export', [MachineController::class, 'exportExcel'])->name('machines.exportExcel');
    Route::resource('/machines/clients/branches/contacts', BranchManagerController::class);
    Route::resource('/machines/clients/branches', BranchController::class);
    Route::get('/machines/model/{id}', [MachineController::class, 'getByMachineModel'])->name('machines.getByMachineModel');
    Route::get('/machine/{serial}', [MachineController::class, 'getMachine'])->name('machines.getMachine');
    Route::resource('/machines/clients', ClientController::class);
    Route::resource('/machines', MachineController::class);
});