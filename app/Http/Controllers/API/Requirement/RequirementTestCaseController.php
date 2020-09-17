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
        $testCases = TestCase::with(['user'])
            ->where('requirement_id', $requirement->id)
            ->get();

        return TestCaseResource::collection($testCases);
    }

    public function store(TestCaseCreateRequest $request, Requirement $requirement)
    {
        $testCase = $requirement->testCases()
            ->create(array_merge($request->validated()['test_case'], ['user_id' => auth()->user()->id]));

        $testSteps = collect($request->validated()['steps'])->map(function ($item) use ($testCase) {
            return [
                'description' => $item['description'],
                'input' => $item['input'],
                'expected_result' => $item['expected_result'],
                'is_passed' => $item['is_passed'],
                'comment' => $item['comment'],
                'test_case_id' => $testCase->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        })->values()->all();

        DB::table('test_case_steps')->insert($testSteps);

        return new TestCaseResource($testCase);
    }

    public function show(Request $request, $testCase)
    {
        $with = $request->has('with') ? explode(',', $request->with) : [];

        return new TestCaseResource(TestCase::with($with)->findOrFail($testCase));
    }

    public function update(TestCaseCreateRequest $request, TestCase $testCase)
    {
        $testCase->update($request->validated()['test_case']);

        // TODO : delete steps that was deleted
        if ($request->has('steps')) {
            foreach ($request->validated()['steps'] as $step) {
                if (!isset($step['id'])) {
                    $testCase->steps()->create($step);
                } else {
                    $instance = TestCaseStep::findOrFail($step['id']);
                    $instance->update($step);
                }
            }
        }
    }

    public function destroy(TestCase $testCase)
    {
        //
    }
}
