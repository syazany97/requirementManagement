<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestCase\TestCaseCreateRequest;
use App\Http\Resources\TestCase\TestCaseResource;
use App\Models\Requirement\Requirement;
use App\Models\TestCase\TestCase;
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
        $testCase = $requirement->testCases()->create($request->validated());

        $testSteps = collect($request->validated()['steps'])->map(function ($item) use ($testCase) {
            return [
                'description' => $item['description'],
                'input' => $item['input'],
                'expected_result' => $item['expected_result'],
                'is_passed' => $item['is_passed'],
                'comment' => $item['comment'],
                'test_case_id' => $testCase->id
            ];
        })->values()->all();

        DB::table('test_case_steps')->insert($testSteps);

        return new TestCaseResource($testCase);
    }

    public function show($testCase)
    {
        return new TestCaseResource(TestCase::with(['steps'])->findOrFail($testCase));
    }

    public function update(Request $request, TestCase $testCase)
    {
        //
    }

    public function destroy(TestCase $testCase)
    {
        //
    }
}
