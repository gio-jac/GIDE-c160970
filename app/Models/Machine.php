<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Machine extends Model
{
    use HasFactory;

    public function machine_model(): HasOne
    {
        return $this->hasOne(MachineModels::class, 'id', 'machine_model_id');
    }

    public function data_client(): HasOne
    {
        return $this->hasOne(DataClients::class, 'id', 'data_client_id');
    }
}
