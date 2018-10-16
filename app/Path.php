<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Path model is the model, representing user graphical svg elements,
 * painted on a board in application visual editor.
 *
 * @package App
 */
class Path extends Model
{
    protected $fillable = [
        'board_id', 'created_by_user_id', 'path_slug', 'stroke_color', 'stroke_width', 'path_data', 'deleted'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'path_slug';
    }

    /**
     * Returns the creator of the path.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by_user_id');
    }

    /**
     * Returns the board it was painted on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo('\App\Board', 'board_id', 'id');
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
