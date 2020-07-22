<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection(Project::withCount(['modules'])
            ->with(['user:id,name'])
            ->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectCreateRequest $request
     * @return ProjectResource
     */
    public function store(ProjectCreateRequest $request)
    {
        return new ProjectResource(Project::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return Response
     */
    public function show($project)
    {
        $project = Project::with(['modules.children',
            'modules.requirements.assigned',
            'modules.requirements.priority'])
            ->findOrFail($project);

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
