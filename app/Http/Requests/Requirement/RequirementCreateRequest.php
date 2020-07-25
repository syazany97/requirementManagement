<?php

namespace App\Http\Requests\Requirement;

use Illuminate\Foundation\Http\FormRequest;

class RequirementCreateRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['required'],
            'numbering' => ['required'],
            'assignees' => ['array', 'present'],
            'assignees.id' => ['exists:users,id']
        ];
    }
}
