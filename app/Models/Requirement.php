<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function requirementable()
    {
        return $this->morphTo();
    }
}
