<?php

namespace App\Models\expenses_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'cc',
        'name',
        'status'
    ];
}
