<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    use HasFactory;
    /*
    public function models(): BelongsToMany{
        return $this->belongsToMany(MachineModels::class, 'models_modules', 'module_id', 'machine_model_id')->withTimestamps();
    }

    public function failures(): BelongsToMany{
        return $this->belongsToMany(Failure::class, 'modules_failures', 'module_id', 'failure_id')->withTimestamps();
    }*/
}
