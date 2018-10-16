<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectAccess extends Model
{
    protected $table = 'project_access';

    protected $fillable = ['user_id','project_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}
