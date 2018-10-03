<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Board extends Model
{

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

    public function messages()
    {
        return $this->hasMany('\App\BoardMessage', 'board_id', 'id');
    }

    public function sourceImageUrl()
    {
        $imagePath = config('images.boards_images_dir') . '/' . $this->thumb_image;
        return Storage::disk('s3')->url($imagePath);
    }

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
