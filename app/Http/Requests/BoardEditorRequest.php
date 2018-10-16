<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardEditorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $hasBoards = $this->project->boards->count();
        $relationIsValid = $this->project->boards->contains($this->board);

        return $hasBoards && $relationIsValid && auth()->user()->can('view', $this->board);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project' => 'exists:project,id',
            'board' => 'exists:board,id'
        ];
    }
}
