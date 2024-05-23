<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Failure extends Model
{
    use HasFactory;
    /*
    public function modules(): BelongsToMany{
        return $this->belongsToMany(Module::class, 'modules_failures', 'failure_id', 'module_id')->withTimestamps();
    }

    public function types(): BelongsToMany{
        return $this->belongsToMany(FailureType::class, 'failures_failure_types', 'failure_id', 'failure_type_id')->withTimestamps();
    }*/
}
