<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'image', 'user_id', 'website_url'
    ];

    /**
     * Returns user, created the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Returns all users, taking part in the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_access');
    }

    /**
     * Returns all activities, related to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'project_id', 'id');
    }

    /**
     * Returns boards, related to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boards()
    {
        return $this->hasMany(Board::class, 'project_id', 'id');
    }

    /**
     * Returns issues, related to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issues()
    {
        return $this->hasMany(Issue::class, 'project_id', 'id');
    }

    /**
     * Returns thumbnail image, related to the project.
     *
     * @return string Project thumbnail image link.
     */
    public function thumbnailUrl(): string
    {
        $imagePath = config('images.project_thumb_dir') . '/' . $this->image;
        return Storage::disk('s3')->url($imagePath);
    }
}
