<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Board extends Model
{
    protected $fillable = ['name', 'project_id', 'image', 'created_by_user_id'];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by_user_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function paths()
    {
        return $this->hasMany(Path::class, 'board_id', 'id');
    }

    /**
     * Return comment points, left on the board.
     *
     * TODO: #1 Issue, program the board message logic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentPoints()
    {
        return $this->hasMany(CommentPoint::class, 'board_id', 'id');
    }

    /**
     * Returns actual board image (for the editor).
     *
     * @return string Board main image for editor
     */
    public function sourceImageUrl(): string
    {
        $imagePath = config('images.boards_images_dir') . '/' . $this->image;
        return Storage::disk('s3')->url($imagePath);
    }

    /**
     * Returns a thumbnail version of full sized board image.
     *
     * @return string Board main image for editor
     */
    public function thumbnailImageUrl(): string
    {
        $imagePath = config('images.boards_images_dir') . '/' . config('images.thumbnail_prefix') . $this->image;
        return Storage::disk('s3')->url($imagePath);
    }

}
