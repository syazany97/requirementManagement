<?php

namespace App\Http\Controllers\API\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\ModuleCreateRequest;
use App\Http\Resources\Module\ModuleResource;
use App\Models\Module;
use App\Models\Project\Project;
use Illuminate\Http\Request;

class ProjectModuleController extends Controller
{
    public function index(Project $project)
    {
        return ModuleResource::collection(Module::completeInformation($project->id)->get());
    }

    public function store(Project $project, ModuleCreateRequest $request)
    {
        return new ModuleResource($project->modules()->create($request->validated()));
    }

    public function show(Module $module)
    {
        return new ModuleResource($module);
    }

    public function update(ModuleCreateRequest $request, Module $module)
    {
        return new ModuleResource($module->update($request->validated()));
    }

    public function destroy(Module $module)
    {
        return $module->delete();
    }


}
