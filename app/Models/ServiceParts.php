<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceParts extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_report_id',
        'part_id',
        'quantity',
        'is_active',
    ];

    public function part(): HasOne
    {
        return $this->hasOne(Part::class, 'id', 'part_id');
    }
}
