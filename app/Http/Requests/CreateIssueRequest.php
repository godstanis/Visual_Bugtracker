<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIssueRequest extends FormRequest
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
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|max:1000|min:3',
            'type_id' =>  'exists:issue_type,id',
            'priority_id' => 'exists:issue_priority,id',
            'assigned_to_user_name' => 'exists:users,name'
        ];
    }
}
