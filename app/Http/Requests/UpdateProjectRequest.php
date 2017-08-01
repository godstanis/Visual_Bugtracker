<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'project_name' => 'string|required|max:25|min:3',
            'project_description' => 'string|max:1000|min:3',
            'project_url' => 'sometimes|nullable|url',
            'project_image' => 'image|nullable'
        ];
    }
}
