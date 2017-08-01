<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectAccess extends Model
{
    protected $table = 'project_access';

    protected $fillable = ['user_id','project_id'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }
}
