<?php

namespace App\Http\Controllers\API\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\ModuleCreateRequest;
use App\Http\Resources\Module\ModuleResource;
use App\Models\Module;
use App\Models\Project\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return AnonymousResourceCollection
     */
    public function index(Project $project)
    {
        return ModuleResource::collection($project->modules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param Request $request
     * @return ModuleResource
     */
    public function store(Project $project, ModuleCreateRequest $request)
    {
        return new ModuleResource($project->modules()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param Module $module
     * @return ModuleResource
     */
    public function show(Module $module)
    {
        return new ModuleResource($module);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ModuleCreateRequest $request
     * @param Module $module
     * @return ModuleResource
     */
    public function update(ModuleCreateRequest $request, Module $module)
    {
        return new ModuleResource($module->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Module $module
     * @return bool
     * @throws Exception
     */
    public function destroy(Module $module)
    {
        return $module->delete();
    }
}
