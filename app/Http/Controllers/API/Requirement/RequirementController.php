<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requirement\RequirementCreateRequest;
use App\Http\Resources\Requirement\RequirementResource;
use App\Models\Module;
use App\Models\Requirement\Requirement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequirementController extends Controller
{
    public function store(Module $module, RequirementCreateRequest $request)
    {
        $requirement = $module->requirements()->create($request->validated());

        if (!$requirement instanceof Requirement) return null;

        if (!empty($request->validated()['assignees'])) {
            foreach ($request->validated()['assignees'] as $assignee) {
                $requirement->assignees()->attach(['assignee_id' => $assignee]);
            }
        }

        return new RequirementResource($requirement->refresh());
    }

    public function show($requirement)
    {
        return new RequirementResource(Requirement::show()->findOrFail($requirement));
    }

    public function update(RequirementCreateRequest $request, Requirement $requirement)
    {
        return new RequirementResource($requirement->update($request->validated()));
    }

    public function destroy(Requirement $requirement)
    {
        $requirement->delete();
    }
}
