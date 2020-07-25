<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Requirement\RequirementStatus;
use Illuminate\Http\Request;

class RequirementStatusController extends Controller
{
    public function __invoke()
    {
        return RequirementStatus::all();
    }
}
