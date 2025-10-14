<?php

namespace App\Models\machine_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'multiple',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class,'client_id', 'id');
    }
}
