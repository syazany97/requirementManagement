<?php

namespace App\Http\Controllers\API\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\ModuleCreateRequest;
use App\Http\Requests\Module\ModuleUpdateRequest;
use App\Http\Resources\Module\ModuleResource;
use App\Models\Module;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectModuleController extends Controller
{
    public function index(Project $project)
    {
        return ModuleResource::collection(Module::completeInformation($project->id)->get());
    }

    public function store(Project $project, ModuleCreateRequest $request)
    {
        $latestModule = $project->modules->sortByDesc('numbering')->first();

        $numbering = $latestModule ? intval($latestModule->numbering) + 1 : 1.0;

        return new ModuleResource($project->modules()->create(array_merge($request->validated(),
            ['numbering' => $numbering])));
    }

    public function show(Module $module)
    {
        return new ModuleResource($module);
    }

    public function update(ModuleUpdateRequest $request, Module $module)
    {
        $module->update($request->validated());

        return new ModuleResource($module);
    }

    public function destroy(Module $module)
    {
        return $module->delete();
    }


}
