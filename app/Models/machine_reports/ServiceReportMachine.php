<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceReportMachine extends Model
{
    use HasFactory;

    protected $table = 'service_report_machine';
    protected $fillable = [
        'service_report_id',
        'machine_id',
        'transport_time_1',
        'transport_time_2',
        'transport_1',
        'transport_2',
        'transport_3',
        'dt',
        'signature_client_name',
    ];
    
    public function serviceReport()
    {
        return $this->belongsTo(ServiceReport::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function details()
    {
        return $this->hasMany(ServiceReportMachineDetail::class);
    }
}
