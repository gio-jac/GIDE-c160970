<?php

namespace App\Models\expenses_reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdvanceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference', 
        'coment',
        'depositDate',
        'approveBy', 
        'status'
    ];

    
}
