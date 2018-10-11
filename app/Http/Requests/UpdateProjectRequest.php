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
            'name' => 'string|required|max:25|min:3',
            'description' => 'string|max:1000|min:3',
            'website_url' => 'sometimes|nullable|url',
            'thumbnail_image' => 'image|nullable'
        ];
    }
}
