<?php

use App\Http\Controllers\expenses_reports\ExpensesController;
use App\Http\Controllers\expenses_reports\AdvanceRequestController;

Route::middleware('auth')->group(function () {
    Route::get('/expenses/{id}', [ExpensesController::class, 'show'])->name('expenses.show');
    Route::get('/listExpenses', [ExpensesController::class, 'listExpense'])->name('expenses.list');
    Route::post('/createExpenses', [ExpensesController::class, 'createExpense'])->name('expenses.create');
    Route::post('/createExpensesGeneral', [ExpensesController::class, 'createExpenseGeneral'])->name('expenses.createGeneral');
    Route::post('/deleteExpensesGeneral', [ExpensesController::class, 'deleteExpenseGeneral'])->name('expenses.deleteExpenseGeneral');
    Route::post('/createTicketsExpense', [ExpensesController::class, 'createTicketExpense'])->name('expenses.createTicketExpense');
    Route::post('deleteTicketsExpense', [ExpensesController::class, 'deleteTicketExpense'])->name('expenses.deleteTicketExpense');
    Route::get('/imagesTickets/{id}', [ExpensesController::class, 'showImageTickets'])->name('images.showTickets');
    Route::post('createCalculatorsExpense', [ExpensesController::class, 'createCalculatorExpense'])->name('expenses.createCalculatorExpense');
    Route::post('/updateExpensesMeals', [ExpensesController::class, 'updateExpensesMeal'])->name('expenses.updateExpensesMeal');
    Route::post('/updateExpensesOthers', [ExpensesController::class, 'updateExpensesOther'])->name('expenses.updateExpensesOther');
    Route::post('/finishExpensesReports', [ExpensesController::class, 'finishExpensesReport'])->name('expenses.finishExpensesReport');
    Route::post('/approveExpensesReports', [ExpensesController::class, 'approveExpensesReport'])->name('expenses.approveExpensesReport');
    Route::get('/transferRequestReports/{report}/file', [ExpensesController::class, 'transferRequestReport'])->name('expenses.file');
    Route::get('/expensesReportExcel/{report}', [ExpensesController::class, 'expenseReportExcel'])->name('expenses.reportExcel');
    Route::post('/requestTransferExpensesReports', [ExpensesController::class, 'requestTransferExpensesReport'])->name('expenses.requestTransferExpensesReport');
    
    
    Route::get('/advanceRequestReports/{report}/file', [AdvanceRequestController::class, 'advanceRequestReport'])->name('advanceRequest.file');
    Route::get('/listAdvanceRequests', [AdvanceRequestController::class, 'listAdvanceRequest'])->name('advanceRequest.list');
    Route::post('/updateAdvancePayExpenses', [AdvanceRequestController::class, 'updateAdvancePay'])->name('advanceRequest.update');
    
});