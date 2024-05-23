<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\User;
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
        'complete_id',
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
        return $this->belongsToMany(Machine::class, ServiceReportMachine::class)->withTimestamps()->withPivot('id','transport_time_1','transport_time_2','transport_1','transport_2','transport_3','dt','signature_client_name');
    }

    public function machineDetails(): HasManyThrough
    {
        return $this->hasManyThrough(
            ServiceReportMachineDetail::class,
            ServiceReportMachine::class,
            'service_report_id', // Foreign key on ServiceReportMachine table
            'service_report_machine_id', // Foreign key on ServiceReportMachineDetail table
            'id', // Local key on ServiceReport table
            'id' // Local key on ServiceReportMachine table
        );
    }
}
