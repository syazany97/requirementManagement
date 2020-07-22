<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\ProjectStatus;
use Illuminate\Http\Request;

class ProjectStatusController extends Controller
{
    public function __invoke()
    {
        return ProjectStatus::all();
    }
}
