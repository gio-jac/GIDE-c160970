<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public $timestamps = true;

    public function serviceReportMachine()
    {
        return $this->belongsTo(ServiceReportMachine::class);
    }

    public function module(): HasOne{
        return $this->hasOne(Module::class, 'id', 'module_id');
    }

    public function failure(): HasOne{
        return $this->hasOne(Failure::class, 'id', 'failure_id');
    }

    public function failureType(): HasOne{
        return $this->hasOne(FailureType::class, 'id', 'failure_type_id');
    }
}
