<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Storage;
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

    public function imageLink()
    {
        $imagePath = config('images.user_avatar_dir') . '/' . $this->profile_image;
        return Storage::disk('s3')->url($imagePath);
    }

}
