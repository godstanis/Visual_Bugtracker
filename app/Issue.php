<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'title', 'project_id', 'description', 'closed', 'type_id', 'priority_id', 'created_by_user_id', 'closed_by_user_id', 'assigned_to_user_id', 'path_id'
    ];

    public function type()
    {
        return $this->hasOne('App\IssueType', 'id', 'type_id');
    }

    public function priority()
    {
        return $this->hasOne('App\IssuePriority', 'id', 'priority_id');
    }

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by_user_id');
    }

    public function assignedUser()
    {
        return $this->hasOne('App\User', 'id', 'assigned_to_user_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function discussion()
    {
        return $this->hasMany('App\IssueDiscussion', 'issue_id', 'id');
    }

    public function close()
    {
        $this->closed = true;
        return $this->update();
    }

    public function open()
    {
        $this->closed = false;
        return $this->update();
    }

    /*
     * Accessors
     * More info: https://laravel.com/docs/eloquent-mutators
     */

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /*
     * Scopes
     * More info: https://laravel.com/docs/eloquent#local-scopes
     */

    public function scopeGetOrdered($query, $columnName = 'created_at', $orderType = 'DESC')
    {
        return $query->orderBy($columnName,$orderType);
    }
}
