<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Machine extends Model
{
    use HasFactory;

    public function machine_model(): HasOne
    {
        return $this->hasOne(MachineModels::class, 'id', 'machine_model_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function production_line(): HasOne
    {
        return $this->hasOne(ProductionLine::class, 'id', 'production_line_id');
    }

    public function serviceReports(): BelongsToMany
    {
        return $this->belongsToMany(ServiceReport::class, 'service_report_machine');
    }
}
