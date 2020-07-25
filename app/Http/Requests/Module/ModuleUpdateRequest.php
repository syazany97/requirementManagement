<?php

namespace App\Http\Requests\Module;

use Illuminate\Foundation\Http\FormRequest;

class ModuleUpdateRequest extends FormRequest
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
            // parent id allowed nullable since it is a top level module
            'parent_id' => ['nullable', 'exists:modules,id']
        ];
    }
}
