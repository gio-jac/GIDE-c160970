<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'shift_id',
        'pieces',
        'sogd',
        'time_on',
        'travel_time',
        'report_type_id',
        'reported_error',
        'branch_manager_id',
        'code_id',
        'actions_taken',
        'reported',
        'arrival',
        'finished',
        'departure',
        'status_id',
        'is_tested',
        'notes',
        'signature_client_name_1',
        'signature_client_name_2',
        'is_active',
        'branch_id',
    ];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function shift(): HasOne
    {
        return $this->hasOne(Shift::class, 'id', 'shift_id');
    }

    public function branchManager(): HasOne
    {
        return $this->hasOne(BranchManager::class, 'id', 'branch_manager_id');
    }

    public function parts(): HasMany
    {
        return $this->hasMany(ServiceParts::class, 'service_report_id', 'id');
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'service_report_machine')->withTimestamps()->withPivot('module_id','failure_id','failure_type_id','transport_time_1','transport_time_2','transport_1','transport_2','dt');
    }
}
