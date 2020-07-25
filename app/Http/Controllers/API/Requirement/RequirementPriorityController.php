<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Requirement\RequirementPriority;
use Illuminate\Http\Request;

class RequirementPriorityController extends Controller
{
    public function __invoke()
    {
        return RequirementPriority::all();
    }
}
