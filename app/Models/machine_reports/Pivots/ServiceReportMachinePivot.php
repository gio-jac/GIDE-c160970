<?php
namespace App\Models\machine_reports\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceReportMachinePivot extends Pivot
{
    protected $table = 'service_report_machine';
    public $timestamps = true;
    protected $fillable = [
        'service_report_id','machine_id',
        'transport_1','transport_2','transport_3',
        'dt','signature_client_name',
    ];
}