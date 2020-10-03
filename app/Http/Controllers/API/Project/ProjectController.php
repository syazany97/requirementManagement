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
    public function index(Request $request)
    {
        $search = $request->has('q') ? $request->q : null;

        return ProjectResource::collection(
            Project::index($search)
//                ->where('user_id', auth()->user()->id)
                ->paginate(20)
                ->appends(['q' => $search])
        );
    }

    public function store(ProjectCreateRequest $request)
    {
        return new ProjectResource(Project::create($request->validated()));
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(ProjectCreateRequest $request, Project $project)
    {
        $project->update($request->validated());
    }

    public function destroy(Project $project)
    {
        try {
            $project->delete();

            return response()->json([
                'message' => 'Project deleted'
            ]);

        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
