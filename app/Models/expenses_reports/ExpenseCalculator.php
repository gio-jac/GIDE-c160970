<?php

namespace App\Models\expenses_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCalculator extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'expense_id', 
        'amount',
        'change',
        'total',
        'currency'
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }
}

