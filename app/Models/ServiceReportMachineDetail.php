<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReportMachineDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_report_machine_id',
        'module_id',
        'failure_id',
        'failure_type_id',
    ];

    public $timestamps = true;

    public function serviceReportMachine()
    {
        return $this->belongsTo(ServiceReportMachine::class);
    }
}
