<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Board extends Model
{
    protected $fillable = ['name', 'project_id', 'thumb_image', 'created_by_user_id'];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by_user_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function paths()
    {
        return $this->hasMany('App\Path', 'board_id', 'id');
    }

    /**
     * Return messages, left on the board.
     *
     * TODO: #1 Issue, programm the board message logic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('\App\BoardMessage', 'board_id', 'id');
    }

    /**
     * Returns actual board image (for the editor).
     *
     * @return string Board main image for editor
     */
    public function sourceImageUrl(): string
    {
        $imagePath = config('images.boards_images_dir') . '/' . $this->thumb_image;
        return Storage::disk('s3')->url($imagePath);
    }

    /**
     * Dirty way to return a json representation
     * for the frontend js code.
     *
     * TODO: Decouple json logic from a model.
     *
     * @deprecated
     * @return array
     */
    public function getAllJsonPaths()
    {
        $json_paths = [];

        foreach($this->paths as $path)
        {
            $json_paths[$path->path_slug] = $path->decodedJsonPath();
        }

        return json_encode($json_paths);
    }
}
