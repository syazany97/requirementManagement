<?php

namespace App\Http\Controllers\API\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\ModuleCreateRequest;
use App\Http\Requests\Module\ModuleUpdateRequest;
use App\Http\Resources\Module\ModuleResource;
use App\Models\Module;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectModuleController extends Controller
{
    public function index(Project $project)
    {
//        $query = DB::table('requirements')
//            ->unionAll(
//                DB::table('requirements')
//                    ->select('requirements.*')
//                    ->join('modules', 'modules.id', '=', 'requirements.module_id')
//            );
//
//        return DB::table('modules')
//            ->withRecursiveExpression('modules', $query)
//            ->get();

//        return ModuleResource::collection(Module::completeInformation($project->id)->get());


        $data = DB::select('WITH RECURSIVE MyCTE AS (
                    SELECT id, parent_id, numbering, created_at FROM modules WHERE parent_id IS NULL
                    UNION
                    SELECT modules.id, modules.parent_id, modules.numbering, modules.created_at FROM modules JOIN MyCTE
                    ON modules.parent_id = MyCTE.id
                    )
                    SELECT * FROM MyCTE;');


//
//         $data = DB::table('modules');
//
         return $data;

//         return response()->json(['data' => 'd']);
    }

    public function store(Project $project, ModuleCreateRequest $request)
    {
        $latestModule = $project->modules->sortByDesc('numbering')->first();

        if ($latestModule) {
            $numbering = intval($latestModule->numbering) + 1;
        } else {
            $numbering = 1.0;
        }

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
