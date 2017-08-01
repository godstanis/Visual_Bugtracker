<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activated'
    ];

    public function project_access()
    {
        return $this->hasMany('App\ProjectAccess', 'user_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function getImageLink()
    {
        return config('images.amazon_base_link') . config('images.user_avatar_dir') . '/' . $this->profile_image;
    }

}
