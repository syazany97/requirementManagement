<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Resources\Module\ModuleResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Module;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index()
    {
        return ProjectResource::collection(Project::withCount(['modules'])
            ->with(['user:id,name'])
            ->paginate(20));
    }

    public function store(ProjectCreateRequest $request)
    {
        return new ProjectResource(Project::create($request->validated()));
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(Project $project)
    {
        //
    }
}
