<?php

namespace App\Models\Requirement;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
