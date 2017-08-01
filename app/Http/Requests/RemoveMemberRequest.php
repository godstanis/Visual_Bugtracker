<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user;
        $project = $this->project;

        $project_access = $user->project_access->where('project_id', $project->id)->first();

        return $project_access !== null;
    }

    public function rules()
    {
        return [];
    }
}
