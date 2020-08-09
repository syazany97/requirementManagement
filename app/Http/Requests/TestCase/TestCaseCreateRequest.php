<?php

namespace App\Http\Requests\TestCase;

use Illuminate\Foundation\Http\FormRequest;

class TestCaseCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'test_case' => ['required', 'array'],
            'test_case.title' => 'required',
            'test_case.description' => ['nullable', 'sometimes'],
            'test_case.preconditions' => ['nullable', 'sometimes'],
//            'test-case.*.priority_id' => ['required', 'exists:requirement_priorities,id'],
            'steps' => ['required', 'array'],
            'steps.*.id' => ['sometimes'],
            'steps.*.description' => ['required'],
            'steps.*.input' => ['nullable'],
            'steps.*.expected_result' => ['nullable'],
            'steps.*.result' => ['nullable'],
            'steps.*.comment' => ['nullable'],
            'steps.*.is_passed' => ['required', 'boolean']
        ];
    }
}
