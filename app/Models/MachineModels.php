<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MachineModels extends Model
{
    use HasFactory;

    public function model_segment(): HasOne
    {
        return $this->hasOne(ModelSegments::class, 'id', 'model_segment_id');
    }
}
