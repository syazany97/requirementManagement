<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requirement\RequirementCreateRequest;
use App\Http\Resources\Requirement\RequirementResource;
use App\Models\Module;
use App\Models\Requirement\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        return new RequirementResource($module->requirements()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement)
    {
        return new RequirementResource($requirement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement)
    {
        //
    }
}
