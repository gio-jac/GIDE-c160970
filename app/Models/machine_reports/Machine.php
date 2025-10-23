<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\machine_reports\Pivots\ServiceReportMachinePivot;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial',
        'production_line_id',
        'line_num',
        'client_id',
        'machine_model_id',
        'position',
        'only_dt',
        'is_active',
    ];

    public function machine_model(): BelongsTo
    {
        return $this->belongsTo(MachineModels::class, 'machine_model_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function production_line(): BelongsTo
    {
        return $this->belongsTo(ProductionLine::class, 'production_line_id')->withDefault([
            'name' => 'N/A'
        ]);
    }

    public function serviceReports(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceReport::class,
            'service_report_machine',
            'machine_id',
            'service_report_id'
        )
        ->using(ServiceReportMachinePivot::class)
        ->withPivot('id','transport_time_1','transport_time_2','transport_1','transport_2','transport_3','dt','signature_client_name')
        ->withTimestamps();
    }
}
