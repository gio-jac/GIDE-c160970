<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'machine_id',
        'machine2_id',
        'shift_id',
        'transport',
        'pieces',
        'sogd',
        'time_on',
        'travel_time',
        'report_type_id',
        'reported_error',
        'module_id',
        'branch_manager_id',
        'failure_id',
        'failure_type_id',
        'code_id',
        'actions_taken',
        'reported',
        'arrival',
        'finished',
        'departure',
        'status_id',
        'is_tested',
        'dt',
        'notes',
        'signature_client_name',
        'is_active',
        'branch_id',
    ];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function machine(): HasOne
    {
        return $this->hasOne(Machine::class, 'id', 'machine_id');
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

    public function module(): HasOne
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }

    public function failure(): HasOne
    {
        return $this->hasOne(Failure::class, 'id', 'failure_id');
    }

    public function failureType(): HasOne
    {
        return $this->hasOne(FailureType::class, 'id', 'failure_type_id');
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
