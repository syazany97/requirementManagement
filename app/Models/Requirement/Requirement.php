<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function requirementable()
    {
        return $this->morphTo();
    }
}
