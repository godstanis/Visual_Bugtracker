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
        $project = $this->project;
        $project_boards = $project->boards;

        $requestedBoard = $this->board;

        $hasBoards = $project_boards->count();
        $relationIsValid = $project_boards->contains($requestedBoard);

        return $hasBoards && $relationIsValid && auth()->user()->can('view', $requestedBoard);
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
