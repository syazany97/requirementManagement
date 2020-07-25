<?php

namespace App\Models\Requirement;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RequirementAssigned extends Model
{
    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }
}
