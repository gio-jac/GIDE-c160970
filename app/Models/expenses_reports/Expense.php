<?php

namespace App\Models\expenses_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'endingDate', 
        'department_id', 
        'cc_id',
        'advanceRequest_id',
        'user_id', 
        'daysAway', 
        'daysPersonalAffairs', 
        'totalDaysAway', 
        'purposeTravel', 
        'methodOfReimbursment', 
        'payAdvance', 
        'payToReturn', 
        'TotalExpense', 
        'destinyFrom',
        'destinyTo',
        'concept',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centerControl()
    {
        return $this->hasOne(CenterControl::class);
    }

    public function department()
    {
        return $this->hasOne(Department::class);
    }

    public function expenseGenerals()
    {
        return $this->hasMany(ExpenseGeneral::class);
    }

    public function expenseMeals()
    {
        return $this->hasMany(ExpenseMeal::class);
    }

    public function expenseothers()
    {
        return $this->hasMany(ExpenseOther::class);
    }

    public function advanceRequests()
    {
        return $this->hasOne(AdvanceRequest::class);
    }
}
