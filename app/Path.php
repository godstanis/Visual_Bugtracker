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
        'board_id', 'user_id', 'path_slug', 'stroke_color', 'stroke_width', 'path_data', 'deleted'
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
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Returns the board it was painted on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

}
