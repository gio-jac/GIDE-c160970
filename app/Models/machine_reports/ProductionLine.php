<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionLine extends Model
{
    use HasFactory;

    public function machines(): HasMany
    {
        return $this->hasMany(Machine::class, 'production_line_id', 'id');
    }
}
