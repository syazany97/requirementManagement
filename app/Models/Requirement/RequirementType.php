<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Model;

class RequirementType extends Model
{
    const FUNCTIONAL = 'functional';
    const NON_FUNCTIONAL = 'non-functional';
    const DOMAIN = 'domain';
}
