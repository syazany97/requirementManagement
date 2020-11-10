<?php

namespace App\Http\Controllers\API\History;

use App\Http\Controllers\Controller;
use App\Http\Resources\Log\LogResource;
use App\Models\CustomActivityLog;
use App\Models\Requirement\Requirement;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class RequirementHistoryController extends Controller
{
    public function __invoke(Requirement $requirement)
    {
        return LogResource::collection(CustomActivityLog::forSubject($requirement)->get());
    }
}
