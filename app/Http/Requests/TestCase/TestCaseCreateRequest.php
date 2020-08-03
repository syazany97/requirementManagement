<?php

namespace App\Http\Requests\TestCase;

use Illuminate\Foundation\Http\FormRequest;

class TestCaseCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'test_case' => ['required', 'array'],
            'test-case.*.title' => 'required',
            'test-case.*.description' => ['nullable', 'sometimes'],
            'test-case.*.preconditions' => ['nullable', 'sometimes'],
//            'test-case.*.priority_id' => ['required', 'exists:requirement_priorities,id'],
            'steps' => ['required', 'array'],
            'steps.*.description' => ['required'],
            'steps.*.input' => ['nullable'],
            'steps.*.expected_result' => ['nullable'],
            'steps.*.result' => ['nullable'],
            'steps.*.comment' => ['nullable'],
            'steps.*.is_passed' => ['required', 'boolean']
        ];
    }
}
