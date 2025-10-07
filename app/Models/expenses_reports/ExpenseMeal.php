<?php

namespace App\Models\expenses_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseMeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id', 
        'general_id', 
        'city', 
        'selectExpense', 
        'restaurant',
        'amount',
        'tip',
        'dateExpense',
        'time'
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }


}
