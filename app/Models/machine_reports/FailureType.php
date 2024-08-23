<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FailureType extends Model
{
    //Solution
    use HasFactory;
    /*
    public function failures(): BelongsToMany{
        return $this->belongsToMany(Failure::class, 'failures_failure_types', 'failure_type_id', 'failure_id')->withTimestamps();
    }*/
}
