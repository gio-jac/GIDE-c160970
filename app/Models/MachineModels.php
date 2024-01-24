<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MachineModels extends Model
{
    use HasFactory;

    public function model_segment(): HasOne
    {
        return $this->hasOne(ModelSegments::class, 'id', 'model_segment_id');
    }
    /*
    public function modules(): BelongsToMany{
        return $this->belongsToMany(Module::class, 'models_modules', 'machine_model_id', 'module_id')->withTimestamps();
    }*/
}
