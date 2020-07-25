<?php

namespace App\Models\Requirement;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RequirementAssignee extends Pivot
{
    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }
}
