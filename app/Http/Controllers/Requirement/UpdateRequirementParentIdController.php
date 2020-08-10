<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequirementParentIdRequest;
use App\Models\Requirement\Requirement;

class UpdateRequirementParentIdController extends Controller
{
    public function __invoke(UpdateRequirementParentIdRequest $request, Requirement $requirement)
    {
        $requirement->update($request->validated());
    }
}
