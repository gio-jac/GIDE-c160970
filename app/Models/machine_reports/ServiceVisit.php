<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ServiceVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'complete_id',
        'user_id',
        'shift_id',
        'branch_id',
        'branch_manager_id',
        'service_date',
        'service_timezone',
        'is_active',
    ];

    protected $casts = [
        'closed' => 'bool',
        'service_date' => 'date:Y-m-d',
        'is_active' => 'bool',
        'service_timezone' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function branchManager(): BelongsTo
    {
        return $this->belongsTo(BranchManager::class);
    }
    
    public function serviceReports(): HasMany
    {
        return $this->hasMany(ServiceReport::class, 'service_visit_id');
    }

    public function scopeWithEditGraph(Builder $q): Builder
    {
        return $q->select([
                'id','user_id','shift_id','branch_id','branch_manager_id',
                'service_date','service_timezone','closed'
            ])
            ->with([
            'user:id,emp,nombre,apellido_paterno',
            'shift:id,name',
            'branch:id,city_id,client_id,address',
            'branch.city:id,name',
            'branch.client:id,name',
            'branchManager:id,name,email,phone,branch_id',
            'serviceReports:id,service_visit_id,pieces,sogd,time_on,travel_time,report_type_id,reported_error,code_id,actions_taken,reported,arrival,finished,departure,status_id,is_tested,notes,branch_id',
            'serviceReports.machines:id,serial,line_num,only_dt,production_line_id,machine_model_id',
            'serviceReports.machines.machine_model:id,model,model_segment_id',
            'serviceReports.machines.machine_model.model_segment:id,segment,is_multi_transport',
            'serviceReports.machines.production_line:id',
            'serviceReports.machines.production_line.machines' => function ($q) {
                $q->select('id','serial','line_num','only_dt','machine_model_id','production_line_id','position')
                ->orderBy('position','asc')
                ->with([
                    'machine_model:id,model,model_segment_id',
                    'machine_model.model_segment:id,segment,is_multi_transport',
                ]);
            },
            'serviceReports.machineDetails' => function ($q) {
                $q->select(
                    'service_report_machine_details.id',
                    'service_report_machine_details.service_report_machine_id',
                    'service_report_machine_details.module_id',
                    'service_report_machine_details.failure_id',
                    'service_report_machine_details.failure_type_id',
                    'service_report_machine_details.dt'
                );
            },
            'serviceReports.parts:id,service_report_id,part_id,quantity',
            'serviceReports.parts.part:id,num_part,descripcion',
        ]);
    }

    public function scopeWithEditGraphCompleteId(Builder $q): Builder
    {
        return $q->withEditGraph()
            ->addSelect(DB::raw('complete_id as completeid')); // alias
    }
    
}
