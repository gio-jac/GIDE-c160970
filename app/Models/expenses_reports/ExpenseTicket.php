<?php

namespace App\Models\expenses_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id', 
        'uuid',
        'concept',
        'amount',
        'ticket'
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }
}
