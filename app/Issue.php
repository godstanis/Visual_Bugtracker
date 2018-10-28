<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'title', 'project_id', 'description', 'closed', 'type_id', 'priority_id', 'user_id', 'closed_by_user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'closed' => 'bool',
    ];

    /**
     * Returns the type of the issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(IssueType::class, 'id', 'type_id');
    }

    /**
     * Returns the priority of the issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function priority()
    {
        return $this->hasOne(IssuePriority::class, 'id', 'priority_id');
    }

    /**
     * Returns the user, created the issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Issue assignees relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'issue_assignees');
    }

    /**
     * Returns the project, where issue is created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * Returns messages left in issue discussion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussion()
    {
        return $this->hasMany(IssueDiscussion::class, 'issue_id', 'id');
    }

    /**
     * CommentPoint, assigned to the issue if exists.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentPoints()
    {
        return $this->hasMany(CommentPoint::class, 'issue_id', 'id');
    }

    /**
     * Closes the Issue.
     *
     * @return bool
     */
    public function close(): bool
    {
        $this->closed = true;
        return $this->update();
    }

    /**
     * Opens the Issue.
     *
     * @return bool
     */
    public function open(): bool
    {
        $this->closed = false;
        return $this->update();
    }

    /*
     * --- Accessors
     * More info: https://laravel.com/docs/eloquent-mutators
     * Carbon documentation: https://carbon.nesbot.com/docs/
     */
    /**
     * Parses timestamp to user-friendly time string.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * --- Scopes
     * More info: https://laravel.com/docs/eloquent#local-scopes
     */
    /**
     * @param $query
     * @param string $columnName
     * @param string $orderType
     * @return mixed
     */
    public function scopeGetOrdered($query, $columnName = 'created_at', $orderType = 'DESC')
    {
        return $query->orderBy($columnName,$orderType);
    }
}
