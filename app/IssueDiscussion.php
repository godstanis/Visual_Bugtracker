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
        return $this->hasOne('\App\Issue', 'id', 'issue_id');
    }

    /**
     * Returns the creator of issue message(comment).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
