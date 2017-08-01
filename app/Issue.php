<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'title', 'project_id', 'description', 'type_id', 'priority_id', 'created_by_user_id', 'closed_by_user_id', 'assigned_to_user_id', 'path_id'
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
}
