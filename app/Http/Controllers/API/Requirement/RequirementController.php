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
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Module $module
     * @param RequirementCreateRequest $request
     * @return RequirementResource
     */
    public function store(Module $module, RequirementCreateRequest $request)
    {
        $requirement = $module->requirements()->create($request->validated());

        if (!empty($request->validated()['assignees'])) {
            foreach ($request->validated()['assignees'] as $assignee) {
                $requirement->assignees()->attach(['assignee_id' => $assignee]);
            }
        }

        return new RequirementResource($requirement->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param Requirement $requirement
     * @return RequirementResource
     */
    public function show(Requirement $requirement)
    {
        return new RequirementResource($requirement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RequirementCreateRequest $request
     * @param Requirement $requirement
     * @return RequirementResource
     */
    public function update(RequirementCreateRequest $request, Requirement $requirement)
    {
        return new RequirementResource($requirement->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Requirement $requirement
     * @return void
     * @throws \Exception
     */
    public function destroy(Requirement $requirement)
    {
        $requirement->delete();
    }
}
