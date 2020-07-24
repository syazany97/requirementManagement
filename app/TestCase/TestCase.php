<?php

namespace App\TestCase;

use App\Models\Requirement\Requirement;
use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }
}
