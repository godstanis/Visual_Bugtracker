<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    protected $fillable = [
        'board_id', 'created_by_user_id', 'path_slug', 'stroke_color', 'stroke_width', 'path_data', 'deleted'
    ];

    public function board()
    {
        return $this->belongsTo('\App\Board', 'board_id', 'id');
    }

    public function decodedJsonPath()
    {
        $path = [
            'path_slug'=>$this->path_slug,
            'stroke'=>$this->stroke_color,
            'stroke-width'=>$this->stroke_width,
            'd'=>$this->path_data
            
        ];
        //$json_path_decoded = json_decode($this->path_json_obj);

        return $path;
    }
}
