<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\machine_reports\Pivots\ServiceReportMachinePivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'service_visit_id',
        'user_id',
        'complete_id',
        'service_date',
        'service_timezone',
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

    protected $casts = [
        'closed' => 'bool',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'code_id');
    }

    public function branchManager(): BelongsTo
    {
        return $this->belongsTo(BranchManager::class, 'branch_manager_id');
    }

    public function parts(): HasMany
    {
        return $this->hasMany(ServiceParts::class, 'service_report_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(
            Machine::class,
            'service_report_machine',
            'service_report_id',
            'machine_id'
        )
        ->using(ServiceReportMachinePivot::class)
        ->withPivot('id','transport_1','transport_2','transport_3','dt','signature_client_name')
        ->withTimestamps();
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

    public function serviceVisit(): BelongsTo
    {
        return $this->belongsTo(ServiceVisit::class, 'service_visit_id');
    }
}
