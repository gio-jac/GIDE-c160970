<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class ServiceVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'complete_id',
        'user_id',
        'shift_id',
        'branch_id',
        'branch_manager_id',
        'service_date',
        'service_timezone',
        'is_active',
    ];

    protected $casts = [
        'closed' => 'bool',
        'service_date' => 'date',
        'is_active' => 'bool',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function branchManager(): BelongsTo
    {
        return $this->belongsTo(BranchManager::class);
    }
    
    public function serviceReports(): HasMany
    {
        return $this->hasMany(ServiceReport::class, 'service_visit_id');
    }
}
