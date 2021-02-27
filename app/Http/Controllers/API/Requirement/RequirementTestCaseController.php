<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestCase\TestCaseCreateRequest;
use App\Http\Resources\TestCase\TestCaseResource;
use App\Models\Requirement\Requirement;
use App\Models\TestCase\TestCase;
use App\Models\TestCase\TestCaseStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequirementTestCaseController extends Controller
{
    public function index(Requirement $requirement)
    {
        return TestCaseResource::collection($requirement->testCases()->with(['user'])->get());
    }

    public function store(TestCaseCreateRequest $request, Requirement $requirement)
    {
        $testCase = $requirement->testCases()->create(array_merge($request->validated()['test_case'], ['user_id' => auth()->user()->id]));

        if (!$testCase instanceof TestCase) return null;

        if (!empty($request->validated()['steps'])) {
            foreach ($request->validated()['steps'] as $step) {
                $testCase->steps()->create($step);
            }
        }

        return new TestCaseResource($testCase);
    }

    public function show(Request $request, $testCase)
    {
        $with = $request->has('with') && !empty($request->with) ? explode(',', $request->with) : [];

        return new TestCaseResource(TestCase::with($with)->findOrFail($testCase));
    }

    public function update(TestCaseCreateRequest $request, TestCase $testCase)
    {
        $testCase->update($request->validated()['test_case']);

        if (!$request->has('steps')) return $testCase;

        $steps = TestCaseStep::whereIn('id', collect($request->validated()['steps'])->pluck('id'))->get();

        // TODO : delete steps that was deleted
        foreach ($request->validated()['steps'] as $step) {
            if (!isset($step['id'])) {
                $testCase->steps()->create($step);
            } else {
                $instance = $steps->firstWhere('id', $step['id']);
                if (!$instance instanceof TestCaseStep) return null;
                $instance->update($step);
            }
        }
    }

    public function destroy(TestCase $testCase)
    {
        //
    }
}
