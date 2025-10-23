<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceReportMachineDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_report_machine_id',
        'module_id',
        'failure_id',
        'failure_type_id',
        'dt'
    ];

    protected $casts = [
        'module_id' => 'integer',
        'failure_id' => 'integer',
        'failure_type_id' => 'integer',
    ];

    public $timestamps = true;

    public function serviceReportMachine()
    {
        return $this->belongsTo(ServiceReportMachine::class);
    }

    public function module(): BelongsTo{
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function failure(): BelongsTo{
        return $this->belongsTo(Failure::class, 'failure_id');
    }

    public function failureType(): BelongsTo{
        return $this->belongsTo(FailureType::class, 'failure_type_id');
    }
}
