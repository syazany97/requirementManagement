<?php

namespace App\Http\Controllers\Requirment;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequirementParentIdRequest;
use App\Models\Requirement\Requirement;
use Illuminate\Http\Request;

class UpdateRequiremenParentIdController extends Controller
{
    public function __invoke(UpdateRequirementParentIdRequest $request, Requirement $requirement)
    {
        $requirement->update($request->validated());
    }
}
