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
        'shift_id',
        'transport',
        'pieces',
        'sogd',
        'time_on',
        'travel_time',
        'report_type_id',
        'reported_error',
        'fault_symptom',
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
        'is_active',
    ];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function machine(): HasOne
    {
        return $this->hasOne(Machine::class, 'id', 'machine_id');
    }

    public function parts(): HasMany
    {
        return $this->hasMany(ServiceParts::class, 'service_report_id', 'id');
    }
}
