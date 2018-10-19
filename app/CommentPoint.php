<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CommentPoint. Represents the actual point on a board,
 * it contains text(optional) or issue reference (optional)
 * so it can be assignable to the existing issue
 * or issue can be manually created with
 * comment point from a board.
 *
 * @package App
 */
class CommentPoint extends Model
{
    protected $fillable = [
        'user_id', 'text', 'position_x', 'position_y'
    ];

    /**
     * A comment creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Returns a board, where comment was created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class,'board_id', 'id');
    }

    /**
     * Return issue, assigned to a comment point.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function issue()
    {
        return $this->hasOne(Issue::class, 'id', 'issue_id');
    }
}
