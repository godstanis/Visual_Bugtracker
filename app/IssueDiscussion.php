<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Issue messages model.
 *
 * @package App
 */
class IssueDiscussion extends Model
{
    protected $fillable = [
        'issue_id', 'user_id', 'text'
    ];

    /**
     * Returns issue, message(comment) was left in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function issue()
    {
        return $this->hasOne(Issue::class, 'id', 'issue_id');
    }

    /**
     * Returns the creator of issue message(comment).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
