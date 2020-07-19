<?php

namespace App\Http\Controllers\API\Module;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;

class ProjectModuleController extends Controller
{
    public function __invoke(Project $project, Request $request)
    {

    }
}
