<?php

use App\Http\Controllers\expenses_reports\ExpensesController;

Route::middleware('auth')->group(function () {
    Route::resource('/expenses', ExpensesController::class);
});