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
        $deletingCreator = $this->project->creator->id === $this->user->id;
        return auth()->user()->can('delete', $this->project) && !$deletingCreator;
    }

    public function rules()
    {
        return [];
    }
}
